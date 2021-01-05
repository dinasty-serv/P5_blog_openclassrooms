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
            $this->entity->delete($comment);
        } elseif ($action === "approve") {
            $comment->setApprove(true);

            $this->entity->update($comment);
        }

        return $this->router->redirect('admin.index');
    }
}
