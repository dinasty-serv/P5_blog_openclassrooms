<?php

namespace App\Controller;

use Framework\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $Posts = $this->entity->getEntity('posts')->findAll();
        
        $Comments = $this->entity->getEntity('comments')->findBy(['approve' => 0], 'DESC', 10);
       
        $this->renderview('back/index.html.twig', ['posts' => $Posts, 'comments' => $Comments]);
    }
}
