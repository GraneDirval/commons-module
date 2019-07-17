<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 17.07.19
 * Time: 13:51
 */

namespace ExtrasBundle\Config;


use Symfony\Component\DependencyInjection\Definition;

class DefinitionReplacer
{

    public static function replacePlaceholder(Definition $definition, $reference, string $placeholder): void
    {
        foreach ($definition->getArguments() as $i => $argument) {
            if (!is_string($argument)) {
                continue;
            }

            if ($argument === $placeholder) {
                $definition->setArgument($i, $reference);
            }
        }
    }
}