<?php

namespace Kumulo\Bundle\LocaleBundle;

use Kumulo\Bundle\LocaleBundle\DependencyInjection\LocaleBundleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LocaleBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new LocaleBundleExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
