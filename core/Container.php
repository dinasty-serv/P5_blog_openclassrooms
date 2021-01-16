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
        //var_dump($id);
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
                    //var_dump($parameters);
                    //var_dump($this->instances);
                    //$parameter->getClass() == null si paramètre est pas une class
                    
                    $args = array_map(
                        fn (ReflectionParameter $parameter) => $this->get($parameter->getClass()->getName()),
                        $parameters
                    );

                    $this->instances[$id] =  $reflectionClass->newInstanceArgs($args);
                }
            }
        }
        
        // var_dump($this->instances);

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
