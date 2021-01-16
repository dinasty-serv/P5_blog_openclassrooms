<?php

namespace Framework;

use Framework\config\Config;

class Mailer
{
    private $transport;

    private $mailer;

    private $newMail;

    public function __construct(Config $config)
    {
        $this->transport = (new \Swift_SmtpTransport(
            $config->getMailParams()['smtp'],
            $config->getMailParams()['port']
        )
            )
        ->setUsername($config->getMailParams()['username'])
        ->setPassword($config->getMailParams()['password']);

        $this->mailer  = new \Swift_Mailer($this->transport);
    }

    public function newMail($object, $from, $to, $message)
    {
        // Create a message
        $this->newMail = (new \Swift_Message($object))
            ->setFrom($from)
            ->setTo($to)
            ->setBody($message, 'text/html');
    }


    public function send()
    {
        return $this->mailer->send($this->newMail);
    }
}
