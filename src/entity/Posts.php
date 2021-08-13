<?php

namespace App\Entity;

class Posts
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var string $title
     */
    private $title;
    /**
     * @var string $content
     */
    private $content;
    /**
     * @var DateTime|string $created_at
     */
    private $created_at;
    /**
     * @var DateTime|string
     */
    private $updated_at;
    /**
     * @var string $slug
     */
    private $slug;
    /**
     * @var int $user_id
     */
    private $user_id;
    /**
     * @var int $categorie_id
     */
    private $categorie_id;


    public function __construct()
    {
        $date = new \DateTime('now');


        if (empty($this->created_at)) {
            $this->created_at =  $date->format('d/m/Y');
        }

        if (empty($this->updatedAt)) {
            $this->updated_at =  $this->created_at;
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return DateTime|string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return DateTime|string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getCategorie()
    {
        return $this->categorie_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */
    public function setCategorie($category_id)
    {
        $this->categorie_id = $category_id;

        return $this;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @description  the value of updated_at
     *
     * @return  self
     */
    public function setUpdatedAt()
    {
        $date = new \DateTime('now');
       
        $this->updated_at =  $date->format('d/m/Y');

        return $this;
    }

    /**
     * @description  the value of created_at
     *
     * @return  self
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @description  the value of content
     *
     * @return  self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @description  the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }


    public function getArray()
    {
        return get_object_vars($this);
    }

    /**
     * @description  the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @description  the value of id
     *
     * @return  self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }
}
