<?php

namespace CommonDataBundle;

use CommonDataBundle\DependencyInjection\Compiler\TemplateConfiguratorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class CommonDataBundle
 *
 * @package CommonDataBundle
 */
class CommonDataBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TemplateConfiguratorCompilerPass());
    }
}