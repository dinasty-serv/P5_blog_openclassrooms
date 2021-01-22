<?php

namespace Framework;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionParameter;

class Container implements ContainerInterface
{
    private array $instances = [];

    public function get($id)
    {
        if (!$this->has($id)) {
            $reflectionClass = new ReflectionClass($id);

            $constructor = $reflectionClass->getConstructor();
            
            if ($constructor === null) {
                $this->instances[$id] = $reflectionClass->newInstance();
            } else {
                $parameters = $constructor->getParameters();
               
                if (empty($parameters)) {
                    $this->instances[$id] = $reflectionClass->newInstance();
                } else {
<<<<<<< HEAD
=======
                   
                    
>>>>>>> b8bd9b7190f42d24321d15376daa7c5005eff870
                    $args = array_map(
                        fn (ReflectionParameter $parameter) => $this->get($parameter->getClass()->getName()),
                        $parameters
                    );

                    $this->instances[$id] =  $reflectionClass->newInstanceArgs($args);
                }
            }
        }
        
        return $this->instances[$id];
    }

    public function has($id)
    {
        return isset($this->instances[$id]);
    }

    public function set($id)
    {
        $this->instances[get_class($id)] =  $id;
        return $this->instances[get_class($id)];
    }
}
