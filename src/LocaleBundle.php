<?php

namespace Kumulo\Bundle\LocaleBundle;

use Kumulo\Bundle\LocaleBundle\DependencyInjection\CompilerPass\LocaleHelperPass;
use Kumulo\Bundle\LocaleBundle\DependencyInjection\LocaleBundleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class LocaleBundle
 * @package Kumulo\Bundle\LocaleBundle
 */
class LocaleBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new LocaleBundleExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new LocaleHelperPass());
    }
}
