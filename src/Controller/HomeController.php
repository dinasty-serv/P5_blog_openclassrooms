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
       
        //$url = $this->router->url('home.index');

       


       
        $this->renderview('front/home.html.twig', ['posts' => $Posts]);
    }

    public function contact(Request $request)
    {
        $mail = $this->container->get(Mailer::class);
       
        if ($request->getMethod() === "POST") {

            //Récupèrer les données du formulaire
            $data =  $request->getParsedBody();
            //Créer le message
            $message = $data['firstname']." ".$data['lastname']." vous contacte pour:".$data['subject']."\r\nMessage: ".$data['message']."\r\nMail du contact: ".$data['email']."\r\n";
            
            $mail->newMail(
                $data['subject'],
                ['email@blog.local' => 'Blog dev'],
                ['nicodu22300@hotmail.fr' => 'Blog test'],
                $message
            );
            
            if ($mail->send()) {
                $this->setFlash(['type' => 'success', 'message' => 'Votre méssage à bien été envoyé, vous recevrez une réponse rapide !']);
            }
        }
        $this->renderview('front/contact.html.twig');
    }
}
