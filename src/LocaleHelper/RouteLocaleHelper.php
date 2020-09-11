<?php

namespace Kumulo\Bundle\LocaleBundle\LocaleHelper;

use Symfony\Component\HttpFoundation\Request;

class RouteLocaleHelper extends AbstractLocaleHelper {

    public function getLocale(Request $request): ?string
    {
        // TODO: Implement getLocale() method.
        return null;
    }
    public function getServiceAlias(): string
    {
        return 'locale_bundle.helpers.route_helper';
    }
}