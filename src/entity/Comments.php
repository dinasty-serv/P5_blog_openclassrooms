<?php
namespace App\Entity;

use DateTime;

class Comments
{
    private $content;
    private $created_at;
    private $approve = 0;
    private $user_id= 1;
    private $post_id;


    public function __construct()
    {
        $date = new DateTime('now');

        $this->created_at = $date->format('d/m/Y');
    }

    public function getContent():string
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

    public function getApprove():bool
    {
        return $this->approve;
    }

    public function setApprove(bool $approve)
    {
        $this->approve = $approve;
    }

    public function getUserId():int
    {
        return $this->user_id;
    }

    public function setUserId(int $user)
    {
        $this->user_id = $user;
    }

    public function getPostId():int
    {
        return $this->post_id;
    }

    public function setPostId(int $post)
    {
        $this->post_id = $post;
    }

    
    public function getArray()
    {
        return get_object_vars($this);
    }
}