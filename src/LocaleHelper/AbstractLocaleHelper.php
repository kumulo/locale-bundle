<?php

namespace Kumulo\Bundle\LocaleBundle\LocaleHelper;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractLocaleHelper implements LocaleHelperInterface {
    public function getLocale(Request $request): ?string
    {
        throw new \Exception('Implement getLocale() method in ' . get_class($this) . ' class.');
    }

    public function getServiceAlias(): string
    {
        return get_class($this);
    }
}