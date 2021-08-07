<?php

namespace Framework;

use Framework\config\Config;

/**
 * Mailer class
 * @author Nicolas de Fontaine <nicolas.defontaine@apizee.com>
 */
class Mailer
{
    private $transport;

    private $mailer;

    private $newMail;

    /**
     * Constructor mail class
     *
     * @param Config $config
     */
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
    /**
     * Create new mail object
     *
     * @param String $object
     * @param String $from
     * @param String $to
     * @param String $message
     * @return void
     */
    public function newMail($object, $from, $to, $message)
    {
        $this->newMail = (new \Swift_Message($object))
            ->setFrom($from)
            ->setTo($to)
            ->setBody($message, 'text/html');
    }

    /**
     * Send email
     *
     * @return void
     */
    public function send()
    {
        return $this->mailer->send($this->newMail);
    }
}
