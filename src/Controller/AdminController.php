<?php
namespace App\Controller;

use Framework\Controller;

class AdminController extends Controller
{
    public function index()
    {
        //liste des articles
        $Posts = $this->entity->getEntity('posts')->findAll();
        
        //Récupèrer les commentaires non approuvé
        $Comments = $this->entity->getEntity('comments')->findBy(['approve' => 0], 'DESC', 10);
       
        $this->renderview('back/index.html.twig', ['posts' => $Posts, 'comments' => $Comments]);
    }
}
