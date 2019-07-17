<?php

namespace DeviceDetectionBundle\DependencyInjection;

use ExtrasBundle\Config\DefinitionReplacer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class DeviceDetectionExtension extends ConfigurableExtension
{
    /**
     * {@inheritdoc}
     */
    public function loadInternal(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');


        $cacherServiceId = $configs['cache']['service_id'];
        $cacher          = new Reference($cacherServiceId);

        $loggerServiceId = $configs['logger']['service_id'];
        $logger          = new Reference($loggerServiceId);


        $def = $container->getDefinition('device_detection.service.device');
        DefinitionReplacer::replacePlaceholder($def, $cacher, '_cache_service_');
        DefinitionReplacer::replacePlaceholder($def, $logger, '_logger_service_');

        $def = $container->getDefinition('device_detection.service.path_provider');
        DefinitionReplacer::replacePlaceholder($def, $configs['db_paths']['optimized_database'], '_optimized_database_path_placeholder_');
        DefinitionReplacer::replacePlaceholder($def, $configs['db_paths']['database'], '_database_path_placeholder_');


    }
}
