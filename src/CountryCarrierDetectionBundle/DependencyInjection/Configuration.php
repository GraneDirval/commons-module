<?php
namespace CountryCarrierDetectionBundle\DependencyInjection;


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
        $rootNode    = $treeBuilder->root('country_carrier_detection');

        $rootNode
            ->children()
                ->arrayNode('cache')
                    ->isRequired()
                    ->children()
                        ->scalarNode('service_id')->isRequired()->end()
                ->end()

            ->end();

        $rootNode
            ->children()
                ->arrayNode('logger')
                    ->isRequired()
                    ->children()
                        ->scalarNode('service_id')->isRequired()->end()
                ->end()

            ->end();

        $rootNode
            ->children()
                ->arrayNode('db_paths')
                    ->isRequired()
                    ->children()
                        ->scalarNode('connection_type_database')->isRequired()->end()
                        ->scalarNode('country_database')->isRequired()->end()
                        ->scalarNode('isp_database')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}