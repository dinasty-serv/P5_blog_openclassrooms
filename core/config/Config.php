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

    private $pathRootUrl = "http://192.168.1.198:8080/OPC/blog/public";

    private $mailParams = array(
        'smtp' => 'smtp.hosts-game-server.com',
        'port' => 587,
        'username' => 'contact@hosts-game-server.com',
        'password' => 'Lyliana01@'
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

    /**
     * Return path root URL
     * @todo Delete funtion
     * @return string
     */
    public function getpathRootUrl():string
    {
        return $this->pathRootUrl;
    }

    /**
     * Return mail params
     *
     * @return array
     */
    public function getMailParams():array
    {
        return $this->mailParams;
    }
}
