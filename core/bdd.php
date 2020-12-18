<?php
namespace Framework;

use Exception;
use PDO;
use Framework\App;
use Framework\config\Config;

class bdd extends Config
{


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
        
        
        return $this->initMysql();
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
            die('Erreur : '.$e->getMessage());
        }
    }
    /**
     * Return obsolute path entity file
     *
     * @param string $entity : Name entity
     * @return void
     */
    public function getPathEntity($entity)
    {
        $modelname = ucwords($entity);

        var_dump($this->getPathsEntityConfig());

        //$path = $this->config->getPathsEntityConfig().'/'.$modelname.'.php';
       
        //return $path;
    }
    /**
     * Verify entity file exists
     *
     * @param string $path: absolute path entity file
     * @return string|null
     */
    private function entityExist($path): ?string
    {
        if (file_exists($path)) {
            return $path;
        } else {
            return false;
        }
    }
}
