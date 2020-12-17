<?php

namespace Framework\route;

/**
 * Class Route
 */

class Route
{
    private $name;
    private $callback;
    private $parameters;
      

    public function __construct(string $name, callable $callback, array $parameters)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }
    
    /**
     * getName
     *
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }
    
    /**
     * getCallback
     *
     * @return callable
     */
    public function getCallback():callable
    {
        return $this->callback;
    }
    
    /**
     * Get the URL parameters
     * @return string[]
     */
    public function getParams():array
    {
        return $this->parameters;
    }
}
