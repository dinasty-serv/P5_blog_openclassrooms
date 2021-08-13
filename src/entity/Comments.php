<?php

namespace App\Entity;

use DateTime;
use PhpParser\Node\Expr\Cast\Object_;

/**
 * @description  Entity class Comments
 * @author Nicolas de Fontaine
 */
class Comments
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var string $content
     */
    private $content;
    /**
     * @var DateTime $created_at
     */
    private $created_at;
    /**
     * @var bool $approve
     */
    private $approve = 0;
    /**
     * @var int $user_id
     */
    private $user_id;
    /**
     * @var int $post_id
     */
    private $post_id;



    public function __construct()
    {
        $date = new DateTime('now');

        $this->created_at = $date->format('d/m/Y');
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return DateTime|string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return bool
     */
    public function getApprove(): bool
    {
        return $this->approve;
    }

    /**
     * @param bool $approve
     */
    public function setApprove(bool $approve)
    {
        $this->approve = $approve;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user_id;
    }

    /**
     * @param $user
     */
    public function setUser($user)
    {
        $this->user_id = $user;
    }

    /**
     * @return int
     */
    public function getPost()
    {
        return $this->post_id;
    }

    /**
     * @param $post
     */
    public function setPost($post)
    {
        $this->post_id = $post;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return get_object_vars($this);
    }

    /**
     * @description the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @description the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
