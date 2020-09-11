<?php

namespace Kumulo\Bundle\LocaleBundle\Listener;

use Kumulo\Bundle\LocaleBundle\Event\LocaleEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoggerSubscriber implements EventSubscriberInterface {
    protected $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            LocaleEvent::NAME => 'makeLog'
        );
    }

    public function makeLog(LocaleEvent $event) {
        $helper = $event->getHelper();
        $locale = $event->getLocale();
        $this->logger->debug("Toto Locale set by {$helper} to : {$locale}", ['locale']);
    }
}