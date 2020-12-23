<?php
namespace Framework\Database;

use Exception;
use PDO;
use Framework\config\Config;

class Bdd extends Config
{
    private $pdo;
    protected $query;


    /**
     * Undocumented function
     *
     * @param array  $db_params
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
                $this->db_password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            return $pdo;
        } catch (Exception $e) {
            die('Erreur Mysql init : '.$e->getMessage());
        }
    }
    /**
     * Execute Sql query
     *
     * @param  string $sql
     * @param  string $pathEntity path entity
     * @return void
     */
    public function execSqlAndFetch($sql, $pathEntity)
    {
        try {
            $res =$this->pdo->query($sql);
            var_dump($res);
            return $res->fetchAll(PDO::FETCH_CLASS, $pathEntity);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function execSimpleSql($sql, $pathEntity)
    {
        try {
            return $this->pdo->query($sql);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
