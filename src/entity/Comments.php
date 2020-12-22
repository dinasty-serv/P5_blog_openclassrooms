<?php
namespace App\Entity;

use DateTime;

class Comments{

    private $id;
    private $content; 
    private $created_at;
    private $updated_at;
    private $approved = false;
    private $user_id= 1;


    public function __construct(){
        $this->created_at = new DateTime('now');
        $this->updated_at = new DateTime('now');
    }
    public function getId():int
    {
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function getContent():string
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function getCreated_at():DateTime
    {
        return $this->created_at;
    }

    public function setCreated_at($created_at){
        $this->created_at = $created_at;
    }

    public function getUpdated_at():DateTime
    {
        return $this->updated_at;
    }

    public function setUpdated_at($updated_at){
        $this->updated_at = $updated_at;
    }

    public function getApproved():bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved)
    {
        $this->approved = $approved;
    }

    public function getUserId():int
    {
        return $this->user_id;
    }

    public function setUserId(int $user)
    {
        $this->user_id = $user;
    }


}