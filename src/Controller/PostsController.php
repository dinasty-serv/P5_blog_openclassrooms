<?php
namespace App\Controller;

use Framework\Controller;

class PostsController extends Controller
{
    public function index()
    {
       

        $this->renderview('front/home.html.twig');
    }

    public function show($slug, $id)
    {
        $this->renderview('front/posts/show.html.twig', ['slug' => $slug, 'id' => $id]);
    }
}
