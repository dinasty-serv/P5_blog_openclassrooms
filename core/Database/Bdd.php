<?php

namespace Framework\Database;

use Exception;
use PDO;
use Framework\config\Config;

class Bdd
{
    private PDO $pdo;
    protected $query;


    /**
     * Init badd class
     *
     * @param array $dbParams
     * @throws Exception
     */
    public function __construct(array $dbParams)
    {
        $this->dbHost = $dbParams['host'];
        $this->dbUser = $dbParams['user'];
        $this->dbPassword = $dbParams['password'];
        $this->dbBaseName = $dbParams['dbname'];
        
        
        
        $this->pdo = $this->initMysql();
    }

    /**
     * Init mysql connection
     *
     * @return PDO instence
     * @throws Exception
     */
    public function initMysql()
    {
        try {
            $pdo = new PDO(
                'mysql:dbname=' . $this->dbBaseName . ';host=' . $this->dbHost.';port=3306',
                $this->dbUser,
                $this->dbPassword,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            return $pdo;
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }
    }

    /**
     * Execute Sql query
     *
     * @param string $sql
     * @param string $pathEntity path entity
     * @param null $data
     * @return array|false
     * @throws Exception
     */
    public function execSqlAndFetch(string $sql, string $pathEntity, $data = null)
    {
        try {
            $statement = $this->pdo->prepare($sql);
          
            $statement->execute($data);
            return $statement->fetchAll(PDO::FETCH_CLASS, $pathEntity);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Execute simple sql request
     *
     * @param string $sql
     * @return void
     * @throws Exception
     */
    public function execSimpleSql(string $sql, $data): bool
    {
        try {
            $statement = $this->pdo->prepare($sql);
          

            if ($statement->execute($data)) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
