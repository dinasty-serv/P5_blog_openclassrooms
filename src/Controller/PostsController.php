<?php

namespace App\Controller;

use Framework\Controller;
use GuzzleHttp\Psr7\ServerRequest as Request;

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
        $comments = $this->entity->getEntity('comments')->findBy(['post_id' => $id,'approve' => true]);
        $this->renderview('front/posts/show.html.twig', ['post' => $Post, 'comments' => $comments]);
    }

    public function newComment($slug, $id, Request $request)
    {
        $data = $request->getParsedBody();
        
        
        $newComment = $this->entity->getEntity('comments');
        
        //Set data
        $newComment->entity->setContent($data['comment']);
        $newComment->entity->setPost($id);
        $newComment->entity->setUser($this->session->getSession('auth')['id']);

        //Save Data
      
        if ($this->entity->save($newComment->entity)) {
            $this->setFlash(['type' => 'success',
            'message' => 'Votre commentaire a bien été posté et est en attente d\'aprobation par un administrateur. '
            ]);

            $this->router->redirect('post.show', ['id' => $id, 'slug' => $slug]);
        }
    }
}
