<?php
namespace App\Controller;

use Framework\Controller;

class PostsController extends Controller
{
    public function index()
    {
        $posts = $this->bdd->getAll('posts');

        $this->renderview('front/home.html.twig', ['posts' => $posts]);
    }

    public function addPosts($request)
    {
    }

    public function show($slug, $id)
    {
        $this->renderview('front/posts/show.html.twig', ['slug' => $slug, 'id' => $id]);
    }
}
