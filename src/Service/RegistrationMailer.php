<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class RegistrationMailer
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendConfirmationEmail(string $userEmail): void
    {
        $email = (new TemplatedEmail())
            ->from('no-reply@now.com')
            ->to($userEmail)
            ->subject('¡Gracias por registrarte!')
            ->htmlTemplate('emails/registration.html.twig')
            ->context([
                'email' => $userEmail,
                'fecha' => new \DateTime()
            ]);

        $this->mailer->send($email);
    }
}
