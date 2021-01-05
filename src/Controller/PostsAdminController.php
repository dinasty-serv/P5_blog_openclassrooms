<?php
namespace App\Controller;

use Framework\Controller;
use GuzzleHttp\Psr7\ServerRequest as Request;

class PostsAdminController extends Controller
{
    public function edit($id, Request $request)
    {
        //liste des articles
        
        $categories = $this->entity->getEntity('categories')->findAll(10);
        $Post = $this->entity->getEntity('posts')->findById($id);
        var_dump($Post);

        if ($request->getMethod() === "POST") {
            //Récupèrer les données du formulaire
            $data =  $request->getParsedBody();

            //Set les nouvelles données
            $Post->setTitle($data['title']);
            $Post->setContent($data['content']);
            $Post->setCategorie($data['categories']);
            $Post->setTitle($data['title']);
            $Post->setUser(1);

            //Save into database
            
            if ($this->entity->update($Post)) {
                return $this->router->redirect('admin.index');
            }
        }
         

        //var_dump($Post);
        //$url = $this->router->url('home.index');
        $this->renderview('back/EditPost.html.twig', ['post' => $Post, 'categories' => $categories]);
    }

    public function delete($id)
    {
    }
}
