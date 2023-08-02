<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\Mime\Email;

class SendMail
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNotificationEmail(string $toEmail, string $subject, string $message): void
    {
        $email = (new Email())
            ->from('amanarodia@gmail.com') // Adresse de l'expéditeur
            ->to($toEmail) // Adresse du destinataire
            ->subject($subject) // Sujet du mail
            ->html($message); // Contenu HTML du mail

        $this->mailer->send($email);
    }
}

 /*    public function construct(private MailerInterface $mailer){
        
    }
        public function sendEmail(): void
        {
            $email = (new Email())
                ->from('hello@example.com')
                ->to('you@example.com')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->html('<p>See Twig integration for better HTML integration!</p>');
    
            $this->$mailer->send($email);
    
            // ...
        } */
