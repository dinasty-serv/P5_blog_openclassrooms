<?php
namespace App\Entity;

class Posts
{
    private $title;

    private $content;

    private $created_at;

    private $updated_at;

    private $slug;

    private $user_id;

    private $category_id;

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
    public function getUser_id()
    {
        return $this->user_id;
    }
    public function getCategory_id()
    {
        return $this->category_id;
    }

    public function getArray()
    {
        return get_object_vars($this);
    }
}
