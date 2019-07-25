<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 25.07.19
 * Time: 12:43
 */

namespace CommonDataBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {

        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('common_data');

        return $treeBuilder;
    }
}