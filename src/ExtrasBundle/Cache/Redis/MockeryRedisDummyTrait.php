<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 06.09.19
 * Time: 11:49
 */

namespace ExtrasBundle\Cache\Redis;


use Mockery\MockInterface;

trait MockeryRedisDummyTrait
{
    private $redisConnectionProvider;

    public function getRedisConnectionProviderMock($className = \Redis::class): MockInterface
    {
        if (!$this->redisConnectionProvider) {
            $this->redisConnectionProvider = \Mockery::spy(\ExtrasBundle\Cache\Redis\RedisConnectionProvider::class);
            $this->redisConnectionProvider->allows(['create' => \Mockery::mock($className)]);
        }

        return $this->redisConnectionProvider;
    }
}