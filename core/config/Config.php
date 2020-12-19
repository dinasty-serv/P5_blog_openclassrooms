<?php

namespace Framework\config;

/**
 * Config class return config params
 */

class Config
{
    private $dbParams = array(
      'user'     => 'admin',
      'password' => 'Apizee22',
      'dbname'   => 'blog',
      'host'     => 'localhost'
   );
    /**
     * Config path entity
     */
    private $paths_entity = 'App\entity';

    /**
     * Config path view
     */
    private $paths_view = 'src/view';
    /**
     * Global path app
     */
    private $globalPath;

    public function __construct()
    {
        $this->globalPath;
    }
    
    /**
     * Return global database config
     *
     * @return void
     */
    public function getDatabaseConfig():array
    {
        return $this->dbParams;
    }
    /**
    * Return global path
    *
    * @return string
    */
    public function getGlobalPath():string
    {
        $this->globalPath = dirname(dirname(__DIR__));
        return $this->globalPath;
    }
    /**
     * Return path entity
     *
     * @return string
     */

    public function getPathsEntityConfig():string
    {
        $path = $this->paths_entity;
        return $path;
    }

    /**
     * Return path view
     *
     * @return string
     */
    public function getPathsViewConfig():string
    {
        return dirname(dirname(__DIR__)).'/'.$this->paths_view;
    }
}
