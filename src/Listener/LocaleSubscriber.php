<?php

namespace Kumulo\Bundle\LocaleBundle\Listener;

use Kumulo\Bundle\LocaleBundle\Event\LocaleEvent;
use Kumulo\Bundle\LocaleBundle\Service\LocalizerService;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class LocaleSubscriber
 * @package Kumulo\Bundle\LocaleBundle
 */
class LocaleSubscriber implements EventSubscriberInterface
{
    /** @var TokenStorageInterface */
    private $token;
    /** @var LocalizerService */
    private $localizer;
    /** @var EventDispatcherInterface */
    private $dispatcher;
    /** @var string */
    private $defaultLocale;
    /** @var array|null */
    private $helpers;
    protected $currentLocale;

    /**
     * LocaleListener constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param LocalizerService $localizer
     * @param EventDispatcherInterface $dispatcher
     * @param string $defaultLocale
     * @param array|null $helpers
     */
    public function __construct(LoggerInterface $logger, TokenStorageInterface $tokenStorage, LocalizerService $localizer, EventDispatcherInterface $dispatcher)
    {
        $this->token = $tokenStorage;
        $this->localizer = $localizer;
        $this->dispatcher = $dispatcher;
        $this->dispatcher->addSubscriber(new LoggerSubscriber($logger));
    }

    public function setDefaultLocale(string $locale) {
        $this->defaultLocale = $locale;
    }

    public function setHelpers(?array $helpers) {
        $this->helpers = $helpers ?? $this->localizer->getHelpers();
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 200)),
            KernelEvents::RESPONSE => array('setContentLanguage')
        );
    }

    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event)
    {
        /** @var Request $request */
        $request = $event->getRequest();

        if (!$event->isMasterRequest()) {
            return;
        }

        if($this->token->getToken() && method_exists($this->token->getToken()->getUser(), 'getLocale')) {
            throw new \BadMethodCallException('The method getLocale does not exist on user object');
        }

        if($new_locale = $this->parseHelpers($request)) {
            $request->setLocale($new_locale);
        }
        else {
            $request->setLocale($this->defaultLocale);
            $this->dispatcher->dispatch(new LocaleEvent('default', $this->defaultLocale));
        }

        // Set currentLocale
        $this->currentLocale = $request->getLocale();
    }
    private function parseHelpers(Request $request) {
        foreach($this->helpers as $helper_name) {
            $helper = $this->localizer->getHelper($helper_name);
            if($locale = $helper->getLocale($request)) {
                $this->dispatcher->dispatch(new LocaleEvent($helper->getServiceAlias(), $locale), LocaleEvent::NAME);
                return $locale;
            }
        }
    }
    /**
     * @param ResponseEvent $event
     * @return Response
     */
    public function setContentLanguage(ResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
        $response->headers->add(array('Content-Language' => $request->getLocale()));

        return $response;
    }
}