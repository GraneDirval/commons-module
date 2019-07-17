<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 13.01.2019
 * Time: 21:12
 */

namespace ExtrasBundle\DependencyInjection;


use ExtrasBundle\Config\DefinitionReplacer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class ExtrasExtension extends ConfigurableExtension
{

    /**
     * Configures the passed container according to the merged configuration.
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('parameters.yml');
        $loader->load('listeners.yml');
        $loader->load('services.yml');
        $loader->load('cache.yml');
        $loader->load('twig.yml');

        $definition = $container->getDefinition('ExtrasBundle\SignatureCheck\ParametersProvider');

        $definition->setArgument(0, $mergedConfig['signature_check']['request_parameter']);
        $definition->setArgument(1, $mergedConfig['signature_check']['secret_key']);


        if (isset($mergedConfig['cache']['use_array_cache']) && $mergedConfig['cache']['use_array_cache']) {
            $loader->load('redis-dummy.yml');
        }

        $redisProviderDefinition = $container->getDefinition('ExtrasBundle\Cache\Redis\RedisConnectionProvider');

        DefinitionReplacer::replacePlaceholder($redisProviderDefinition, $mergedConfig['cache']['redis_host'], '_redis_host_placeholder_');
        DefinitionReplacer::replacePlaceholder($redisProviderDefinition, $mergedConfig['cache']['redis_port'], '_redis_port_placeholder_');

    }
}