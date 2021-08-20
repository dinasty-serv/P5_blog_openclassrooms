<?php

namespace Framework\config;

/**
 * Config class return config params
 */

class Config
{
    private $dbParams = array(
      'user'     => 'root',
      'password' => 'Apizee22',
      'dbname'   => 'blog',
      'host'     => 'dev_db'
    );

    private $pathRootUrl = "http://blog.local";

    private $mailParams = array(
        'smtp' => '172.19.0.4',
        'port' => 25,

    );
    
    /**
     * Config path entity
     */
    private $pathsEntity = 'App\entity';

    /**
     * Config path view
     */
    private $pathsView = 'src/view';
    

   
    /**
     * Return global database config
     *
     * @return void
     */
    public function getDatabaseConfig(): array
    {
        return $this->dbParams;
    }
    /**
     * Return global path
     *
     * @return string
     */
    public function getGlobalPath(): string
    {
        $this->globalPath = dirname(dirname(__DIR__));
        return $this->globalPath;
    }
    /**
     * Return path entity
     *
     * @return string
     */

    public function getPathsEntityConfig(): string
    {
        $path = $this->pathsEntity;
        return $path;
    }

    /**
     * Return path view
     *
     * @return string
     */
    public function getPathsViewConfig(): string
    {
        return dirname(dirname(__DIR__)) . '/' . $this->pathsView;
    }

    /**
     * Return path root URL
     * @return string
     */
    public function getpathRootUrl(): string
    {
        return $this->pathRootUrl;
    }

    /**
     * Return mail params
     *
     * @return array
     */
    public function getMailParams(): array
    {
        return $this->mailParams;
    }
}
