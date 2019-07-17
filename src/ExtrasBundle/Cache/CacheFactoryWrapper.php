<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 19.04.18
 * Time: 15:54
 */

namespace ExtrasBundle\Cache;


class CacheFactoryWrapper
{
    /**
     * @var ICacheServiceFactory
     */
    private $ICacheServiceFactory;

    /**
     * CacheFactoryWrapper constructor.
     * @param ICacheServiceFactory $ICacheServiceFactory
     */
    public function __construct(ICacheServiceFactory $ICacheServiceFactory)
    {
        $this->ICacheServiceFactory = $ICacheServiceFactory;
    }


    /**
     * @param int    $database
     * @param string $namespace
     * @param array  $options
     * @return ICacheService
     */
    public function createCacheService(int $database, string $namespace, array $options = []): ICacheService
    {
        return $this->ICacheServiceFactory->createCacheService($database, $namespace, $options);
    }

}