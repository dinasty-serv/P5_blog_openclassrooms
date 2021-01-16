<?php

namespace App\Entity;

use DateTime;
use PhpParser\Node\Expr\Cast\Object_;

class Comments
{
    private $id;
    private $content;
    private $created_at;
    private $approve = 0;
    private $user_id = 1;
    private $post_id;



    public function __construct()
    {
        $date = new DateTime('now');

        $this->created_at = $date->format('d/m/Y');
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }


    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getApprove(): bool
    {
        return $this->approve;
    }

    public function setApprove(bool $approve)
    {
        $this->approve = $approve;
    }

    public function getUser()
    {
        return $this->user_id;
    }

    public function setUser($user)
    {
        $this->user_id = $user;
    }

    public function getPost()
    {
        return $this->post_id;
    }

    public function setPost($post)
    {
        $this->post_id = $post;
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
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
