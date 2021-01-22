<?php

namespace App\Controller;

use App\Entity\Users;
use Framework\Controller;
use Framework\Mailer;
use GuzzleHttp\Psr7\ServerRequest as Request;

class UsersController extends Controller
{
    /**
     * Login function
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        if ($request->getMethod() === "POST") {
            $data = $request->getParsedBody();
            /** @var Users $user */
            $user = $this->entity->getEntity('users')->findOneBy(['email' => $data['email']]);

            if (!empty($user) && password_verify($data['password'], $user->getPassword())) {
                $this->session->auth($user);
                $this->setFlash(['type' => 'success', 'message' => "Bonjour " . $user->getUsername()]);
                return $this->router->redirect('home.index');
            } else {
                $this->setFlash(['type' => 'danger', 'message' => 'Email ou mots de passe invalide']);
            }
        }

        $this->renderview('front/login.html.twig');
    }
    /**
     * Register function
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        if ($request->getMethod() === "POST") {
            $newUser = $this->entity->getEntity('users');

            $date = new \DateTime();
            $data = $request->getParsedBody();
            $verif = $newUser->findOneBy(['email' => $data['email']]);

            
            if (!empty($verif)) {
                $this->setFlash(['type' => 'danger', 'message' => 'L\'utilisateur existe déja !']);
                return $this->router->redirect('users.login');
            } elseif ($data['password'] != $data['password1']) {
                $this->setFlash(['type' => 'danger', 'message' => 'Les mots de passe ne coresponde pas.']);
                return $this->router->redirect('users.login');
            } else {
                $passHash = password_hash($data['password'], PASSWORD_DEFAULT);
                $newUser->entity->setUsername($data['username']);
                $newUser->entity->setPassword($passHash);
                $newUser->entity->setEmail($data['email']);
                $newUser->entity->setCreatedAt($date->format('d/m/Y'));

                if ($this->entity->save($newUser->entity)) {
                    $this->setFlash(['type' => 'success',
                    'message' => 'Merci ! votre compte a bien été crée, vous pouvez vous connecter.'
                    ]);
                    return $this->router->redirect('users.login');
                }
            }
        }
    }
    /**
     * Lost password function
     *
     * @param Request $request
     * @return void
     */
    public function lostPassword(Request $request)
    {
        if ($request->getMethod() === "POST") {
            $mail = $this->container->get(Mailer::class);
            $data = $request->getParsedBody();
            $user = $this->entity->getEntity('users')->findOneBy(['email' => $data['email']]);

            if (empty($user)) {
                $this->setFlash(['type' => 'danger', 'message' => 'Email incconu']);
                return $this->router->redirect('users.login');
            }

            $user->setToken($this->generateToken());

            if ($this->entity->update($user)) {
                $mail->newMail(
                    'Réinitialisation de mots de passe',
                    ['email@blog.local' => 'Blog dev'],
                    [$user->getEmail() => 'Blog test'],
                    $this->twig->twig->render(
                        'emails/lostPassword.html.twig',
                        ['user' => $user]
                    )
                );

                if ($mail->send()) {
                    $this->setFlash(['type' => 'success',
                    'message' => 'Vous allez recevoir un email de réinitialisation de votre mots de passe'
                    ]);
                    return $this->router->redirect('home.index');
                }
            }
        }
        $this->renderview('front/lostPassword.html.twig');
    }
    /**
     * Reset password function
     *
     * @param string $token
     * @param Request $request
     * @return void
     */
    public function resetPassword(string $token, Request $request)
    {
        $user = $this->entity->getEntity('users')->findOneBy(['reset_token' => $token]);
        if (empty($user)) {
            $this->setFlash(['type' => 'danger', 'message' => 'Token invalide']);

            return $this->router->redirect('home.index');
        } else {
            if ($request->getMethod() === "POST") {
                $data = $request->getParsedBody();

                if ($data['password'] != $data['password1']) {
                    $this->setFlash(['type' => 'danger', 'message' => 'Les mots de passe ne coresponde pas.']);
                    return $this->router->redirect('users.login');
                } else {
                    $passHash = password_hash($data['password'], PASSWORD_DEFAULT);

                    $user->setPassword($passHash);
                    $user->setToken(null);
                    if ($this->entity->update($user)) {
                        $this->setFlash(['type' => 'success', 'message' => 'Votre mots de passe a bien été modifié.']);
                        return $this->router->redirect('users.login');
                    }
                }
            }
        }
        $this->renderview('front/resetPassword.html.twig', ['token' => $token]);
    }
    /**
     * Logout function
     *
     * @return void
     */
    public function logout()
    {
        if ($this->session->getSession('auth')) {
            $this->session->deleteSession('auth');
            $this->setFlash(['type' => 'success', 'message' => 'Vous avez été déconnecté']);
            return $this->router->redirect('home.index');
        }
    }
    /**
     * Edit profile function
     *
     * @param Request $request
     * @return void
     */
    public function editProfile(Request $request)
    {
        if ($request->getMethod() === "POST") {
            $data = $request->getParsedBody();

            $this->user->setUsername($data['username']);

            if ($this->entity->update($this->user)) {
                $this->setFlash(['type' => 'success', 'message' => 'Votre profil à été mis à jours']);
                return $this->router->redirect('users.profile');
            }
        }
    }
    /**
     * Get infos profil function
     *
     * @return void
     */
    public function profile()
    {
        $comments = $this->entity->getEntity('comments')->findBy([
            'user_id' => $this->user->getId()
            ]);

        $this->renderview('front/membre/profile.html.twig', ['comments' => $comments]);
    }
    /**
     * Change password request
     *
     * @return void
     */
    public function changePassword()
    {
        $this->user->setToken($this->generateToken());

        if ($this->entity->update($this->user)) {
            $this->setFlash(['type' => 'success', 'message' => 'Vous pouvez modifié votre mots de passe']);
            return $this->router->redirect('users.resetpassword', ['token' => $this->user->getToken()]);
        }
    }
}
