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
                return $reflectionClass->newInstance();
            } else {
                $parameters = $constructor->getParameters();
                
                var_dump(
                    fn (ReflectionParameter $parameter) => $this->get($parameter->getClass()->getName()),
                    $parameters
                );
                $this->instances[$id] =  $reflectionClass->newInstanceArgs(
                    array_map(
                        fn (ReflectionParameter $parameter) => $this->get($parameter->getClass()->getName()),
                        $parameters
                    )
                );
            }
        }

        return $this->instances[$id];
    }

    public function has($id)
    {
        return isset($this->instances[$id]);
    }
}
