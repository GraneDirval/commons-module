<?php

namespace ExtrasBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class TraceableCachePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('data_collector.cache')) {


            $definition = $container->getDefinition('app.cache.array_factory');
            $definition->addMethodCall('setCacheDataCollector', [new Reference('data_collector.cache')]);


            $definition = $container->getDefinition('app.cache.redis_connection_provider');
            $definition->addMethodCall('setCollector', [new Reference('data_collector.cache')]);


        }

    }
}
