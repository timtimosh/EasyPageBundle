<?php

namespace Mtt\EasyPageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mtt_easy_page');

        $rootNode
            ->children()
                ->scalarNode('page_entity')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('image_entity')->defaultNull()->cannotBeEmpty()->end()
                ->scalarNode('gallery_entity')->defaultNull()->cannotBeEmpty()->end()
                ->scalarNode('easy_admin_integration')->defaultNull()
            ->end()
        ->end();


        return $treeBuilder;
    }
}
