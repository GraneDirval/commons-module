<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 19.04.18
 * Time: 16:17
 */

namespace ExtrasBundle\Cache\ArrayCache;


use ExtrasBundle\Cache\ICacheService;
use ExtrasBundle\Cache\ICacheServiceFactory;
use InvalidArgumentException;

class ArrayCacheFactory implements ICacheServiceFactory
{


    /**
     * @param int    $database
     * @param string $namespace
     * @param array  $options
     * @return ICacheService
     */
    public function createCacheService(int $database, string $namespace, array $options = []): ICacheService
    {
        return new ArrayCacheService();
    }
}