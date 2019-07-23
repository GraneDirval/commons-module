<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 31.05.18
 * Time: 13:27
 */

namespace ExtrasBundle\Cache\Redis;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\TraceableAdapter;
use Symfony\Component\Cache\DataCollector\CacheDataCollector;

class RedisConnectionProvider
{

    /** @var string */
    private $host;

    /** @var string */
    private $port;

    /**
     * @var string
     */
    private $namespace;
    /**
     * @var CacheDataCollector
     */
    private $collector;

    /**
     * RedisConnectionProvider constructor.
     * @param string $host
     * @param string $port
     * @param string $namespace
     */
    public function __construct(string $host, string $port, string $namespace, CacheDataCollector $collector = null)
    {
        $this->host      = $host;
        $this->port      = $port;
        $this->namespace = $namespace;
        $this->collector = $collector;
    }

    /**
     * @param       $database
     * @param array $options
     *
     * @return \Predis\Client|\Redis|\RedisCluster
     */
    public function create($database, $options = [])
    {
        return RedisAdapter::createConnection(
            sprintf('redis://%s:%s/' . $database, $this->host, $this->port),
            $options
        );
    }

    public function createAdapter($database, $namespace = '', $options = []): AdapterInterface
    {
        $connection = $this->create($database, $options);

        $adapter = new TraceableAdapter(
            new RedisAdapter($connection, $namespace)
        );

        $this->collector->addInstance(sprintf('app.extras.%s', $namespace), $adapter);

        return $adapter;
    }
}