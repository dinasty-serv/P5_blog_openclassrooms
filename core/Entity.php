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
        $this->database = new Bdd($this->config->getDatabaseConfig());
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
    /**
     * init new entity
     *
     * @param string $table
     * @return self
     */
    public function getEntity(string $table):self
    {
        $this->query = new Query($table);

        $this->table = $table;

        $path = $this->getPathEntity();
        
        $this->entity = new $path();
        //$this->query->from($this->table);

        return $this;
    }
    /**
     * Save into database
     *
     * @return bool
     */
    public function save($entity):bool
    {
        $this->entity = $entity;
        var_dump($this->entity);
        $data =$this->entity->getArray();
        $this->sql = $this->query
            ->table($this->entity->table)
            ->action("UPDATE")
            ->insert($data)
            ->__toString();
        // var_dump($this->sql);
        return  $this->database->execSimpleSql($this->sql);
    }
    /**
     * Update unto database
     *
     * @return boolean
     */
    public function update($entity):bool
    {
        $this->entity = $entity;

        $data =$this->entity->getArray();
        $this->sql = $this->query
            
            ->action("UPDATE")
            ->update($data, $this->entity->getId())
            ->__toString();
       
        return  $this->database->execSimpleSql($this->sql);
    }

    public function delete($entity):bool
    {
        $this->entity = $entity;

        $data =$this->entity->getArray();
        $this->sql = $this->query
            
            ->action("DELETE")
            ->where(["id" => $this->entity->getId()])
            ->__toString();
       
        return  $this->database->execSimpleSql($this->sql);
    }

    
    /**
     * FintById into database
     *
     * @param integer $id
     * @return object
     */
    public function findById(int $id):object
    {
        $this->sql = $this->query
            ->action('SELECT')
            ->where(['id' => $id])
            ->__toString();

        return $this->database->execSqlAndFetch($this->sql, $this->getPathEntity())[0];
    }

    public function findOneBy(array $params, $limit = 1)
    {
        $this->sql =  $this->query
            ->action('SELECT')
            ->where($params)
            ->limit($limit)
            ->__toString();

        return $this->database->execSqlAndFetch($this->sql, $this->getPathEntity())[0];
    }

    public function findAll(?int $limit = null, ?string  $order = 'DESC')
    {
        $this->sql =  $this->query
            ->action('SELECT')
            ->orderBy('id', $order)
            ->limit($limit)
            ->__toString();
      
        return $this->database->execSqlAndFetch($this->sql, $this->getPathEntity());
    }

    public function findBy(array $params, string $order = 'DESC', int $limit = null)
    {
        $this->sql =  $this->query
            ->action('SELECT')
            ->where($params)
            ->orderBy('id', $order)
            ->limit($limit)
            ->__toString();
        return $this->database->execSqlAndFetch($this->sql, $this->getPathEntity());
    }
}
