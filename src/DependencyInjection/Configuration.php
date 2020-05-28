<?php

namespace Otcstores\EventLog\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('otcstores_event_log');
        $root = $treeBuilder->getRootNode();
        $root
            ->children()
            ->arrayNode('service')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('username_callable')->defaultValue('otcstores_event_log.username_callable.token_storage')->end()
            ->end()
            ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
