<?php
namespace App\Controller;

use Framework\Controller;

class PostsController extends Controller
{
    public function index()
    {
        $Posts = $this->entity->getEntity('posts')->findAll();
        $this->renderview('front/posts/index.html.twig', ['posts' => $Posts]);
    }

    public function show($slug, $id)
    {
        $Post = $this->entity->getEntity('posts')->findOneBy(["slug" => $slug, "id" => $id]);

       

        
        $this->renderview('front/posts/show.html.twig', ['post' => $Post]);
    }

    public function newComment($slug, $id)
    {
    }
}
