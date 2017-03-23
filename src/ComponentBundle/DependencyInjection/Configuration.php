<?php

namespace ComponentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('news_component');

        $rootNode
            ->children()
                ->arrayNode('news')
                    ->children()
                        ->integerNode('per_frontend_request')
                            ->defaultValue(10)
                        ->end()
                        ->integerNode('news_offset')
                            ->defaultValue(0)
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
