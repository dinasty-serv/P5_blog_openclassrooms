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
        $newComment->entity->setPostId($id);
        //var_dump($newComment);

        //Save Data
        if ($this->entity->save()) {
            $this->router->redirect('post.show', ['id' => $id, 'slug' => $slug]);
        }
    }
}
