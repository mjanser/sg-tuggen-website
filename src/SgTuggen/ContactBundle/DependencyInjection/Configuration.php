<?php

/*
 * This file is part of the SgTuggen\ContactBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\ContactBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sg_tuggen_contact');

        $rootNode
            ->children()
                ->arrayNode('email')
                    ->children()
                        ->scalarNode('subject')->defaultValue('%s')->end()
                        ->arrayNode('recipients')
                            ->prototype('scalar')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
