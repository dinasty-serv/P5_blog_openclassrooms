<?php

namespace Framework;

use GuzzleHttp\Psr7\Request;

abstract class Controller extends App
{
    public function renderview(string $vue, array $params = [])
    {
        echo $this->twig->render($vue, $params);
    }
}
