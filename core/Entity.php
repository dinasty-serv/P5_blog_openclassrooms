<?php
namespace Framework;

use Framework\config\Config;
use Framework\Database\Query;
use Framework\Database\Bdd;

class Entity
{
    private $table;
    public $query;
    private $database;
    public $entity;
    private $sql;
    private $config;
    
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->database = new Bdd($this->config->getDatabaseConfig(), $this->config->getPathsEntityConfig());
    }

    /**
     * Return obsolute path entity file
     *
     * @param  string $entity : Name entity
     * @return void
     */
    public function getPathEntity()
    {
        $modelname = ucwords($this->table);
        $path = $this->config->getPathsEntityConfig()."\\".$modelname;

        return $path;
    }

    public function getEntity($table)
    {
        $this->query = new Query($table);
        $this->table = $table;

        $path = $this->getPathEntity();
        
        $this->entity = new $path();
        
        //$this->query->from($this->table);

        return $this;
    }

    public function save()
    {
        $data =$this->entity->getArray();
        $this->sql = $this->query
            ->action("INSERT")
            ->insert($data)
            ->__toString();

        return $this->database->execSql($this->sql, $this->getPathEntity());
    }

   


    public function findById($id)
    {
        $this->sql = $this->query
            ->action('SELECT')
            ->where(['id' => $id])
            ->__toString();

        return $this->database->execSql($this->sql, $this->getPathEntity());
    }

    public function findOneBy(array $params, $limit = 1)
    {
        $this->sql =  $this->query
            ->action('SELECT')
            ->where($params)
            ->limit($limit)
            ->__toString();

        return $this->database->execSql($this->sql, $this->getPathEntity())[0];
    }

    public function findAll(?int $limit = null, ?string  $order = 'DESC')
    {
        $this->sql =  $this->query
            ->action('SELECT')
            ->orderBy('id', $order)
            ->limit($limit)
            ->__toString();

        return $this->database->execSql($this->sql, $this->getPathEntity());
    }

    public function findBy(array $params, string $order = 'DESC', int $limit = null)
    {
        $this->sql =  $this->query
            ->action('SELECT')
            ->where($params)
            ->orderBy('id', $order)
            ->limit($limit)
            ->__toString();

        return $this->database->execSql($this->sql, $this->getPathEntity());
    }
}
