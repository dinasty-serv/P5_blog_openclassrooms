<?php

namespace App\Controller;

use Framework\Controller;
use GuzzleHttp\Psr7\ServerRequest as Request;

class PostsAdminController extends Controller
{
    
    public function edit(int $id, Request $request)
    {
        $categories = $this->entity->getEntity('categories')->findAll(10);
        $Post = $this->entity->getEntity('posts')->findById($id);


        if ($request->getMethod() === "POST") {
            $data =  $request->getParsedBody();

            $Post->setContent($data['content']);
            $Post->setCategorie($data['categories']);
            $Post->setTitle($data['title']);
            $Post->setUpdated_at();
            $Post->setUser(1);
            if ($this->entity->update($Post)) {
                $this->setFlash(['type' => 'success', 'message' => 'L\'article à bien été modifié.']);

                return $this->router->redirect('admin.index');
            }
        }
         

        $this->renderview('back/post/EditPost.html.twig', ['post' => $Post, 'categories' => $categories]);
    }

    public function add(Request $request)
    {
        $categories = $this->entity->getEntity('categories')->findAll(10);
        $Post = $this->entity->getEntity('posts');


        if ($request->getMethod() === "POST") {
            $data =  $request->getParsedBody();

            $Post->entity->setTitle($data['title']);
            $Post->entity->setContent($data['content']);
            $Post->entity->setCategorie($data['categories']);
            $Post->entity->setSlug($this->generateSlug($data['title']));
            $Post->entity->setUser(1);
           
            if ($this->entity->save($Post->entity)) {
                $this->setFlash(['type' => 'success', 'message' => 'L\'article à bien été ajouté.']);

                return $this->router->redirect('admin.index');
            }
        }
         
        $this->renderview('back/post/AddPost.html.twig', ['post' => $Post, 'categories' => $categories]);
    }


    public function delete(int $id)
    {
        $post = $this->entity->getEntity('posts')->findById($id);

        if ($this->entity->delete($post)) {
            $this->setFlash(['type' => 'success', 'message' => 'L\'article à bien été supprimé.']);

            return $this->router->redirect('admin.index');
        }
    }
}
