<?php
namespace Framework;

use Framework\config\Config;

class Entity extends Config
{


 /**
     * Return obsolute path entity file
     *
     * @param string $entity : Name entity
     * @return void
     */
    public function getPathEntity($entity)
    {
        $modelname = ucwords($entity);
        $path = $this->getPathsEntityConfig()."\\".$modelname;

        return $path;
    }
    /**
     * Verify entity file exists
     *
     * @param string $path: absolute path entity file
     * @return string|null
     */
    private function entityExist($path): ?string
    {
        try {
            file_exists($path);
            return $path;
        } catch (\Exception $e) {
            die('Erreur  : '.$e->getMessage());
        }
    }
}
