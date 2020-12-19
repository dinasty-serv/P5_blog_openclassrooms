<?php

namespace Framework;

class Controller extends App
{
    public function renderview(string $vue, array $params = null)
    {
        echo $this->twig->render($vue, $params);
    }
}
