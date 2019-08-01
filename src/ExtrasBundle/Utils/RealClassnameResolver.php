<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 01.08.19
 * Time: 13:12
 */

namespace ExtrasBundle\Utils;


use Doctrine\ORM\EntityManagerInterface;

class RealClassnameResolver
{

    public static function resolveName(string $interface, EntityManagerInterface $entityManager): string
    {
        $metadata      = $entityManager->getClassMetadata($interface);
        $realClassName = $metadata->getName();

        return $realClassName;
    }
}