<?php
namespace App\Controller;

use Framework\Controller;
use Framework\Mailer;
use GuzzleHttp\Psr7\ServerRequest as Request;

class HomeController extends Controller
{
    public function index()
    {
        //Récupèrer les 3 derniers articles
        $Posts = $this->entity->getEntity('posts')->findAll(3);
        $this->renderview('front/home.html.twig', ['posts' => $Posts]);
    }

    public function contact(Request $request)
    {
        $mail = $this->container->get(Mailer::class);
       
        if ($request->getMethod() === "POST") {

            //Récupèrer les données du formulaire
            $data =  $request->getParsedBody();
            
            $mail->newMail(
                'Demande de contact',
                ['email@blog.local' => 'Blog dev'],
                ["nicodu22300@hotmail.fr" => 'Blog test'],
                $this->twig->twig->render(
                    'emails/contact.html.twig',
                    ['user' => $data]
                )
            );

            if ($mail->send()) {
                $this->setFlash(['type' => 'success', 'message' => 'Votre méssage à bien été envoyé, vous recevrez une réponse rapide !']);
            }
        }
        $this->renderview('front/contact.html.twig');
    }
}
