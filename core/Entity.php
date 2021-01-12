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
    private $leftJoin;
    
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
        
       
        $this->getLeftJoin($this->entity);
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
        
        $data =$this->entity->getArray();
        foreach ($data as $k => $v) {
            if (is_object($v)) {
                $data[$k] = $v->getId();
            }
        }

        unset($data['id']);

        $this->sql = $this->query
            ->action("INSERT")
            ->insert($data)
            ->limit(null)
            ->__toString();
        return  $this->database->execSimpleSql($this->sql, $data);
    }
    /**
     * Update into database
     *
     * @return boolean
     */
    public function update($entity):bool
    {
        $this->entity = $entity;

        $data =$this->entity->getArray();
        foreach ($data as $k => $v) {
            if (is_object($v)) {
                $data[$k] = $v->getId();
            }
        }
        unset($data['id']);

        $this->sql = $this->query
            
            ->action("UPDATE")
            ->update($data, $this->entity->getId())
            ->limit(null)
            ->__toString();
        var_dump($this->sql);
        return  $this->database->execSimpleSql($this->sql, $data);
    }

    public function delete($entity):bool
    {
        $this->entity = $entity;
        
        $this->sql = $this->query
            
            ->action("DELETE")
            ->where(["id" => $this->entity->getId()])
            ->__toString();
       
        return  $this->database->execSimpleSql($this->sql, ["id" => $this->entity->getId()]);
    }

    
    /**
     * FintById into database
     *
     * @param integer $id
     * @return object
     */
    public function findById(int $id)
    {
        $sql = $this->query
            ->action('SELECT')
            ->where(['id' => $id]);

        $this->sql = $sql->__toString();

        //var_dump($this->sql);

        return $this->leftJoin($this->database->execSqlAndFetch($this->sql, $this->getPathEntity(), ['id' => $id]), true);
    }

    public function findOneBy(array $params, $limit = 1)
    {
        $this->sql =  $this->query
            ->action('SELECT')
            ->where($params)
            ->limit($limit)
            ->__toString();

        return $this->leftJoin($this->database->execSqlAndFetch($this->sql, $this->getPathEntity(), $params), true);
    }

    public function findAll(?int $limit = null, ?string  $order = 'DESC')
    {
        $this->sql =  $this->query
            ->action('SELECT')
            ->orderBy('id', $order)
            ->limit($limit)
            ->__toString();
       
        return $this->leftJoin($this->database->execSqlAndFetch($this->sql, $this->getPathEntity(), null), false);
    }

    public function findBy(array $params, string $order = 'DESC', int $limit = null)
    {
        //var_dump($this->leftJoin);
        $this->sql =  $this->query
            ->action('SELECT')
            ->where($params)
            ->orderBy('id', $order)
            ->limit($limit)
            ->__toString();
      
        
        return $this->leftJoin($this->database->execSqlAndFetch($this->sql, $this->getPathEntity(), $params), false);
    }
    /**
     * Construct sql request and set entity for foreign keys
     *
     * @param entity $entry
     * @param boolean $single if single return
     * @return void
     */
    private function leftjoin($entry, bool $single)
    {
        if (!empty($this->leftJoin)) {
            for ($i =0;$i<count($entry);$i++) {
                foreach ($this->leftJoin as $k => $v) {
                    $functionGet = $v['functionGet'];
                    $functionSet = $v['functionSet'];


                    $getWhere = $entry[$i];
                    $sql = new Query($v['table']);
                    $sql->action('SELECT');
                    $sql->where(['id' => $getWhere->$functionGet()]);
                    $sql = $sql->__toString();
                    
                    $entityGet = $this->database->execSqlAndFetch($sql, $v['entity'], ['id' => $getWhere->$functionGet()]);

                    if (count($entityGet) === 1) {
                        $entry[$i]->$functionSet($entityGet[0]);
                    } else {
                        $entry[$i]->$functionSet($entityGet);
                    }
                }
            }
        }
        if ($single) {
            return $entry[0];
        } else {
            return $entry;
        }
    }
    /**
     * checks if there are foreign keys
     *
     * @param [type] $entity
     * @return void
     */
    private function getLeftJoin()
    {
        $leftJoin = [];
        foreach ($this->entity->getArray() as $k => $v) {
            $otherentity = [];
            $other = explode('_', $k);

            if (count($other) > 1 && $other[count($other)-1] === 'id') {
                $param = ucwords($other[0]);
                $class_name = "";
                $table_name = "";
               
                for ($i = 0; $i < count($other)-1; $i++) {
                    $class_name .= ucwords($other[$i]);
                    $table_name .= $other[$i].'_';
                }
                $table_name = substr($table_name, 0, -1);

                

                $otherentity['entity'] =  $this->config->getPathsEntityConfig()."\\".$class_name.'s';
                $otherentity['params'][$table_name.'_id']  = $table_name.'s.id';
                $otherentity['select'] = $table_name.'_id';
                $otherentity['table'] = $table_name.'s';
                $otherentity['functionSet'] = "set".ucwords($table_name);
                $otherentity['functionGet'] = "get".ucwords($table_name);

                
                $leftJoin[] = $otherentity;
            }

            //var_dump($leftJoin);
        }

        $this->leftJoin = $leftJoin;
    }
}
