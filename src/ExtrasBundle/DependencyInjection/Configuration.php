<?php
/**
 * Created by IntelliJ IDEA.
 * User: bharatm
 * Date: 25/07/17
 * Time: 10:39 AM
 */

namespace ExtrasBundle\DependencyInjection;


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
        $rootNode    = $treeBuilder->root('extras');

        $rootNode
            ->children()
                ->arrayNode('signature_check')
                    ->children()
                        ->scalarNode('request_parameter')->defaultValue('signature')->end()
                        ->scalarNode('secret_key')->isRequired()->end()
                    ->end()
                ->end()
                ->arrayNode('cache')
                    ->children()
                        ->scalarNode('use_array_cache')->defaultFalse()->end()
                        ->scalarNode('redis_host')->isRequired()->end()
                        ->scalarNode('redis_port')->isRequired()->end()
                    ->end()
                ->end()
                ->scalarNode('app_version_file_path')->defaultValue('%kernel.root_dir/../var/app_version')->end()
            ->end();

        return $treeBuilder;
    }
}