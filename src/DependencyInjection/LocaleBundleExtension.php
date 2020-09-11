<?php

namespace Kumulo\Bundle\LocaleBundle\DependencyInjection;

use Kumulo\Bundle\LocaleBundle\LocaleHelper\LocaleHelperInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class LocaleBundleExtension
 * @package Kumulo\Bundle\LocaleBundle
 */
class LocaleBundleExtension extends Extension {
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($configs as $subConfig) {
            $config = array_merge($config, $subConfig);
        }
        $container->setParameter('locale_bundle.available_locales', $config['available_locales']);
        $container->setParameter('locale_bundle.default_locale', $config['default_locale']);
        $container->setParameter('locale_bundle.helpers', count($config['helpers']) ? $config['helpers'] : null);

        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.yaml');

        $container->registerForAutoconfiguration(LocaleHelperInterface::class)
            ->addTag('locale_bundle.helpers')
        ;
    }
}