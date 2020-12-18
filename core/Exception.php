<?php
namespace Framework;

class Exception
{
    public function generateExeption($error)
    {
        throw new \Exception($error);
    }
}
