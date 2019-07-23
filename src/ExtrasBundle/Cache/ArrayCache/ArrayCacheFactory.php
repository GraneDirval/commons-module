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
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\TraceableAdapter;
use Symfony\Component\Cache\DataCollector\CacheDataCollector;

class ArrayCacheFactory implements ICacheServiceFactory
{
    /**
     * @var CacheDataCollector
     */
    private $cacheDataCollector;

    /**
     * ArrayCacheFactory constructor.
     */
    public function __construct(CacheDataCollector $cacheDataCollector = null)
    {
        $this->cacheDataCollector = $cacheDataCollector;
    }


    /**
     * @param int    $database
     * @param string $namespace
     * @param array  $options
     * @return ICacheService
     */
    public function createCacheService(int $database, string $namespace, array $options = []): ICacheService
    {
        $adapter = new TraceableAdapter(
            new ArrayAdapter()
        );

        if($this->cacheDataCollector){
            $this->cacheDataCollector->addInstance(sprintf('app.extras.%s', $namespace), $adapter);
        }

        return new ArrayCacheService($adapter);
    }
}