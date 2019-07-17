<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 17.07.19
 * Time: 13:41
 */

namespace DeviceDetectionBundle\Service;


class PathProvider
{
    /**
     * @var string
     */
    private $databasePath;
    /**
     * @var string
     */
    private $optimizedDatabasePath;


    /**
     * PathProvider constructor.
     * @param string $databasePath
     * @param string $optimizedDatabasePath
     */
    public function __construct(string $databasePath, string $optimizedDatabasePath)
    {
        $this->databasePath          = $databasePath;
        $this->optimizedDatabasePath = $optimizedDatabasePath;
    }

    /**
     * @return string
     */
    public function getDatabasePath(): string
    {
        return $this->databasePath;
    }

    /**
     * @return string
     */
    public function getOptimizedDatabasePath(): string
    {
        return $this->optimizedDatabasePath;
    }

}