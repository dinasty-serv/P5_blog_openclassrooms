<?php
namespace App\Entity;

use DateTime;

class Categories
{
    private $id;
    private $name;
    private $slug;
    

    public function getId():int
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }


    public function getName():string
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSlug():string
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
    public function getArray()
    {
        return get_object_vars($this);
    }
}
