<?php

namespace Kumulo\Bundle\LocaleBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class LocaleEvent extends Event {

    public const NAME = 'locale_bundle.events.locale';

    protected $helper = "";
    protected $locale = "";

    public function __construct(string $helper, string $locale) {
        $this->helper = $helper;
        $this->locale = $locale;
    }

    public function getLocale():string {
        return $this->locale;
    }

    public function getHelper():string {
        return $this->helper;
    }
}