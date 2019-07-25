<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 25.07.19
 * Time: 12:29
 */

namespace CommonDataBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class CommonDataExtension extends ConfigurableExtension
{

    /**
     * Configures the passed container according to the merged configuration.
     * @param array            $mergedConfig
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('fixtures.yml');
        $loader->load('repositories.yml');

    }
}