<?php

namespace Kumulo\Bundle\LocaleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Configuration
 * @package Kumulo\Bundle\LocaleBundle
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('locale_bundle');
        $default =  Yaml::parseFile(dirname(__DIR__).'/Resources/config/locale_bundle.yaml');

        $treeBuilder->getRootNode()
                ->children()
                    ->arrayNode('available_locales')
                        ->scalarPrototype()->end()
                        ->defaultValue($default['locale_bundle']['available_locales'])
                    ->end()
                    ->arrayNode('helpers')
                        ->scalarPrototype()->end()
                        ->defaultValue($default['locale_bundle']['helpers'])
                    ->end()
                    ->scalarNode('default_locale')
                        ->defaultValue($default['locale_bundle']['default_locale'])
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
