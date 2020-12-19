<?php

namespace Framework;

class Controller extends App
{
    public function renderview(string $vue, array $params = [])
    {
        echo $this->twig->render($vue, $params);
    }
}
