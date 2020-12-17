<?php
namespace Framework;

use Framework\route\Route;

class App
{
    public function __construct()
    {
        $router = new Router();
    }

    public function run()
    {
    }
}
