<?php

namespace Kumulo\Bundle\LocaleBundle\Service;

use Kumulo\Bundle\LocaleBundle\LocaleHelper\LocaleHelperInterface;

/**
 * Class LocalizerService
 * @package Kumulo\Bundle\LocaleBundle
 */
class LocalizerService {

    private $helpers = [];

    public function addHelper(LocaleHelperInterface $helper) {
        $this->helpers[get_class($helper)] = $helper;
    }

    /**
     * @return LocaleHelperInterface[]
     */
    public function getHelpers() {
        return $this->helpers;
    }

    /**
     * @param $alias
     * @return LocaleHelperInterface
     */
    public function getHelper($alias):LocaleHelperInterface {
        if($alias instanceof LocaleHelperInterface) {return $alias;}
        if(!$this->helpers[$alias] || !$this->helpers[$alias] instanceof LocaleHelperInterface) {
            throw new \Exception("The request helper $alias is not available.");
        }
        return $this->helpers[$alias];
    }
}
