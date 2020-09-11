<?php

namespace Kumulo\Bundle\LocaleBundle\DependencyInjection\CompilerPass;

use Kumulo\Bundle\LocaleBundle\Service\LocalizerService;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class LocaleHelperPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition(LocalizerService::class);

        foreach ($container->findTaggedServiceIds('locale_bundle.helpers') as $id => $tags) {
            $definition->addMethodCall('addHelper', [new Reference($id)]);
        }
    }
}
