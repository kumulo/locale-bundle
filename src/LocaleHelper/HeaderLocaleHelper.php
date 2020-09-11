<?php

namespace Kumulo\Bundle\LocaleBundle\LocaleHelper;

use Symfony\Component\HttpFoundation\Request;

class HeaderLocaleHelper extends AbstractLocaleHelper {

    const ACCEPT_LANGUAGE_HEADER = "accept-language";
    const RATIO_DELIMITER = ";q=";
    private $available_locales = [];

    public function __construct(array $available_locales) {
        $this->available_locales = $available_locales;
    }

    public function getLocale(Request $request): ?string
    {
        return $this->getLocaleInHeaders($request);
    }
    public function getServiceAlias(): string
    {
        return 'locale_bundle.helpers.header_helper';
    }

    /**
     * @param Request $request
     * @return null|string
     */
    public function getLocaleInHeaders(Request $request):?string {
        if($request->headers->has(self::ACCEPT_LANGUAGE_HEADER)) {
            $header_languages = explode(',', $request->headers->get(self::ACCEPT_LANGUAGE_HEADER));
            foreach ($header_languages as $header_language) {
                if(strpos($header_language, self::RATIO_DELIMITER)) {
                    list($language, $ratio) = explode(self::RATIO_DELIMITER, $header_language);
                    if(in_array($language, $this->available_locales)) return $language;
                } else {
                    if(in_array($header_language, $this->available_locales)) return $header_language;
                }
            }
        }
        return null;
    }
}