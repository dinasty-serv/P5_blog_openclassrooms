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


        if ($request->getMethod() === "POST") {
            //Récupèrer les données du formulaire
            $data =  $request->getParsedBody();

            //Set les nouvelles données
            $Post->setContent($data['content']);
            $Post->setCategorie($data['categories']);
            $Post->setTitle($data['title']);
            $Post->setUser(1);

            //Save into database
            
            if ($this->entity->update($Post)) {
                $this->setFlash(['type' => 'success', 'message' => 'L\'article à bien été modifié.']);

                return $this->router->redirect('admin.index');
            }
        }
         

        //var_dump($Post);
        //$url = $this->router->url('home.index');
        $this->renderview('back/post/EditPost.html.twig', ['post' => $Post, 'categories' => $categories]);
    }

    public function add(Request $request)
    {
        //liste des articles
        
        $categories = $this->entity->getEntity('categories')->findAll(10);
        $Post = $this->entity->getEntity('posts');


        if ($request->getMethod() === "POST") {
            //Récupèrer les données du formulaire
            $data =  $request->getParsedBody();
            
            //Set les nouvelles données
            $Post->entity->setTitle(addslashes($data['title']));
            $Post->entity->setContent(addslashes($data['content']));
            $Post->entity->setCategorie($data['categories']);
            $Post->entity->setSlug(addslashes($this->generateSlug($data['title'])));
            $Post->entity->setUser(1);
           
            //Save into database

            if ($this->entity->save($Post->entity)) {
                $this->setFlash(['type' => 'success', 'message' => 'L\'article à bien été ajouté.']);

                return $this->router->redirect('admin.index');
            }
        }
         

        //var_dump($Post);
        //$url = $this->router->url('home.index');
        $this->renderview('back/post/AddPost.html.twig', ['post' => $Post, 'categories' => $categories]);
    }


    public function delete($id)
    {
        $post = $this->entity->getEntity('posts')->findById($id);

        if ($this->entity->delete($post)) {
            $this->setFlash(['type' => 'success', 'message' => 'L\'article à bien été supprimé.']);

            return $this->router->redirect('admin.index');
        }
    }
}
