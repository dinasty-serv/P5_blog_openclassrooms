<?php
namespace App\Controller;

use Framework\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $Posts = $this->bdd->getAll('posts');
        var_dump($Posts);
        $this->renderview('front/home.html.twig');
    }

    public function contact(){
        $this->renderview('front/contact.html.twig');
    }
}
