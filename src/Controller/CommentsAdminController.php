<?php

namespace App\Controller;

use Framework\Controller;
use GuzzleHttp\Psr7\ServerRequest as Request;

class CommentsAdminController extends Controller
{
    public function index()
    {
        $comments = $this->entity->getEntity('comments')->findAll();

        $this->renderview('back/comment/index.html.twig', ['comments' => $comments]);
    }
    public function appouvOrDelete($id, $action)
    {
        $comment = $this->entity->getEntity('comments')->findById($id);
        
        if ($action === "delete") {
            if ($this->entity->delete($comment)) {
                $this->setFlash(['type' => 'success', 'message' => 'Le commentaire à bien été supprimé']);
            }
        } elseif ($action === "approve") {
            $comment->setApprove(true);

            if ($this->entity->update($comment)) {
                $this->setFlash(['type' => 'success', 'message' => 'Le commentaire à bien été approuvé']);
            }
        }

        return $this->router->redirect('admin.index');
    }
}
