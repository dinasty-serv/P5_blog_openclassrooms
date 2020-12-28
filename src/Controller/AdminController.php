<?php
namespace App\Controller;

use Framework\Controller;

class AdminController extends Controller
{
    public function index()
    {
        //liste des articles
        $Posts = $this->entity->getEntity('posts')->findAll(3);
        //Récupèrer les commentaires non approuvé
        $Comments = $this->entity->getEntity('comments')->findBy(['approve' => 0]);
        //var_dump($Comments);
        //$url = $this->router->url('home.index');
       
        $this->renderview('back/index.html.twig', ['posts' => $Posts]);
    }
}
