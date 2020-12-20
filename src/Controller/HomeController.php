<?php
namespace App\Controller;

use Framework\Controller;

class HomeController extends Controller
{
    public function index()
    {
        //Récupèrer les 3 derniers articles
        $Posts = $this->entity->getEntity('posts')->findAll(3);
                

        var_dump($Posts);
        
        $this->renderview('front/home.html.twig', ['posts' => $Posts]);
    }

    public function contact()
    {
        $this->renderview('front/contact.html.twig');
    }
}
