<?php

namespace App\Entity;

use DateTime;

/**
 * @description Entity class Categories
 * @author Nicolas de Fontaine
 */
class Categories
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var string $slug
     */
    private $slug;

    /**
     * @description Get ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @description Set ID
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @description Get Name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @description Set name
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @description get Slug
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @description Set slug
     * @param $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @description Transform Object into array
     * @return array
     */
    public function getArray()
    {
        return get_object_vars($this);
    }
}
