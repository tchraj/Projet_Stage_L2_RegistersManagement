<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    #[Route('/mail', name: 'app_mail')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new TemplatedEmail())
            ->from("amanarodia@gmail.com")
            ->to('esthergayi29@gmail.com')
            ->subject('Nouvelle visite')
            ->htmlTemplate('emails/mail.html')
            ->context([
                'nom' => 'Jane',
                'prenom' => 'Doe',
                'job' => 'Dev symfony',
                'presentation ' => 'Voici une nouvelle recrue'
            ]);
        $mailer->send($email);
        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }
}

