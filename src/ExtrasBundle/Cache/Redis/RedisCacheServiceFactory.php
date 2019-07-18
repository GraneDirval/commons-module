<?php

namespace ExtrasBundle\Cache\Redis;

use ExtrasBundle\Cache\ICacheService;
use ExtrasBundle\Cache\ICacheServiceFactory;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Exception\InvalidArgumentException;

class RedisCacheServiceFactory implements ICacheServiceFactory
{

    /**
     * @var RedisConnectionProvider
     */
    private $connectionProvider;
    /**
     * @var string
     */
    private $namespace;

    /**
     * RedisCacheServiceFactory constructor.
     *
     * @param RedisConnectionProvider $connectionProvider
     * @param string                  $namespace
     */
    public function __construct(RedisConnectionProvider $connectionProvider, string $namespace)
    {
        $this->connectionProvider = $connectionProvider;
        $this->namespace          = $namespace;
    }


    /**
     * @param int    $database
     * @param string $namespace
     * @param array  $options
     * @return ICacheService
     */
    public function createCacheService(int $database, string $namespace, array $options = []): ICacheService
    {
        $connection = $this->connectionProvider->create($database, $options);

        return new RedisCacheService(new RedisAdapter($connection, $namespace));

    }
}
