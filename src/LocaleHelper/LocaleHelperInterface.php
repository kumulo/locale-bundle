<?php

namespace Kumulo\Bundle\LocaleBundle\LocaleHelper;

use Symfony\Component\HttpFoundation\Request;

interface LocaleHelperInterface {
    public function getLocale(Request $request):?string;
    public function getServiceAlias():string;
}