<?php
namespace App\Entity;

class Posts
{
    private $id;
    
    private $title;

    private $content;

    private $created_at;

    private $updated_at;

    private $slug;

    private $user_id;

    private $categorie_id;


    public function __construct()
    {
        $date = new \DateTime('now');

        //$this->updated_at =  $date->format('d/m/Y');

        if (empty($this->created_at)) {
            $this->created_at =  $date->format('d/m/Y');
        }

        if (empty($this->updated_at)) {
            $this->updated_at =  $date->format('d/m/Y');
        }
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getCreated_at()
    {
        return $this->created_at;
    }
    public function getUpdated_at()
    {
        return $this->updated_at;
    }
    public function getSlug()
    {
        return $this->slug;
    }
    public function getUser()
    {
        return $this->user_id;
    }
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
     * Set the value of updated_at
     *
     * @return  self
     */
    public function setUpdated_at()
    {
        $date = new \DateTime('now');
       
        $this->updated_at =  $date->format('d/m/Y');

        return $this;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the value of title
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
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }
}
