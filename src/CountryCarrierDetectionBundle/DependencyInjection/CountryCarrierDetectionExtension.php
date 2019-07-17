<?php

namespace CountryCarrierDetectionBundle\DependencyInjection;

use ExtrasBundle\Config\DefinitionReplacer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class CountryCarrierDetectionExtension extends ConfigurableExtension
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

        $def = $container->getDefinition('CountryCarrierDetectionBundle\Service\ConnectionTypeService');
        DefinitionReplacer::replacePlaceholder($def, $configs['db_paths']['connection_type_database'], '_connection_type_database_placeholder_');
        DefinitionReplacer::replacePlaceholder($def, $cacher, '_cache_service_');
        DefinitionReplacer::replacePlaceholder($def, $logger, '_logger_service_');

        $def = $container->getDefinition('CountryCarrierDetectionBundle\Service\ISPService');
        DefinitionReplacer::replacePlaceholder($def, $configs['db_paths']['isp_database'], '_isp_database_placeholder_');
        DefinitionReplacer::replacePlaceholder($def, $cacher, '_cache_service_');
        DefinitionReplacer::replacePlaceholder($def, $logger, '_logger_service_');

        $def = $container->getDefinition('CountryCarrierDetectionBundle\Service\CountryService');
        DefinitionReplacer::replacePlaceholder($def, $configs['db_paths']['country_database'], '_country_database_placeholder_');
        DefinitionReplacer::replacePlaceholder($def, $cacher, '_cache_service_');
        DefinitionReplacer::replacePlaceholder($def, $logger, '_logger_service_');

    }

}
