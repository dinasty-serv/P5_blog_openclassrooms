<?php
namespace Framework;

use Exception;
use PDO;
use Framework\App;
use Framework\config\Config;
use Framework\Entity;
class bdd extends Config
{

    private $pdo;


    /**
     * Undocumented function
     *
     * @param array $db_params
     * @param string $pathsModel
     */
    public function __construct(array $db_params)
    {
        $this->db_host = $db_params['host'];
        $this->db_user = $db_params['user'];
        $this->db_password = $db_params['password'];
        $this->db_baseName = $db_params['dbname'];
        
        
        $this->pdo = $this->initMysql();
    }

    /**
     * Init mysql connection
     *
     * @return mysql instence
     */
    public function initMysql()
    {
        try {
            $pdo = new PDO(
                'mysql:dbname='.$this->db_baseName.';host='.$this->db_host,
                $this->db_user,
                $this->db_password
            );
            return $pdo;
        } catch (Exception $e) {
            die('Erreur Mysql init : '.$e->getMessage());
        }
    }

    public function getAll($table){
        $entity = New Entity(); 
        $sql = "SELECT * FROM ".$table;
        
       $entity->getPathEntity($table);

     
     return $this->execSql($sql,$entity->getPathEntity($table));


    }



    private function preparSql($sql){
        $sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        return $sth;

    }

    public function execSql($sql,$pathEntity){
        var_dump($pathEntity);
         $res =$this->pdo->query($sql, $pathEntity);
         return $res;
    }


   
}