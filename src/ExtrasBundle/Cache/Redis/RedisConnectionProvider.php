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

    private $pool = [];

    /**
     * RedisConnectionProvider constructor.
     * @param string $host
     * @param string $port
     * @param string $namespace
     */
    public function __construct(string $host, string $port, string $namespace)
    {
        $this->host      = $host;
        $this->port      = $port;
        $this->namespace = $namespace;
    }

    /**
     * @param CacheDataCollector $collector
     */
    public function setCollector(CacheDataCollector $collector): void
    {
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
        $dsn = sprintf('redis://%s:%s/%s', $this->host, $this->port, (int)$database);
        $key = md5($dsn);

        if (isset($this->pool[$key])) {
            return $this->pool[$key];
        }

        $options    = array_merge(['persistent_id' => $key], $options);
        $connection = RedisAdapter::createConnection(
            $dsn,
            $options
        );

        $this->pool[$key] = $connection;

        return $connection;
    }

    public function createAdapter($database, $namespace = '', $options = []): AdapterInterface
    {
        $connection = $this->create($database, $options);

        $adapter = new TraceableAdapter(
            new RedisAdapter($connection, $namespace)
        );

        if ($this->collector && $namespace) {
            $this->collector->addInstance(sprintf('app.extras.%s', $namespace), $adapter);
        }

        return $adapter;
    }
}