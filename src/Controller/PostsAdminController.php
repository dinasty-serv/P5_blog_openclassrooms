<?php
namespace App\Controller;

use Framework\Controller;
use GuzzleHttp\Psr7\ServerRequest as Request;

class PostsAdminController extends Controller
{
    public function edit($id, Request $request)
    {
        //liste des articles
        $Post = $this->entity->getEntity('posts')->findById($id);
        $categories = $this->entity->getEntity('categories')->findAll();
        if ($request->getMethod() === "POST") {
            $data =  $request->getParsedBody();
            
            var_dump($data);
        }
         

        //var_dump($Post);
        //$url = $this->router->url('home.index');
        $this->renderview('back/EditPost.html.twig', ['post' => $Post, 'categories' => $categories]);
    }
}
