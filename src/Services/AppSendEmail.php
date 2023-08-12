<?php

namespace App\Services;

use Monolog\Logger;
use Symfony\Component\Mime\Email;
use Monolog\Handler\RotatingFileHandler;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class AppSendEmail
{
    private $mailer;

    private $logger;
    
    public function __construct(
        MailerInterface $mailer
    )
    {
        $this->mailer = $mailer;
        $this->logger = new Logger('app_notification_logger');
        $this->logger->pushHandler(new RotatingFileHandler(dirname( __DIR__, 2).'/var/log/notification.log', 7, Logger::DEBUG));
    }

    public function sendUnique($sender, $receiver, $object, $message, $template = null)
    {
        $adresses = explode(',', $receiver);
        $email = (new TemplatedEmail())
            ->from($sender)
            ->to(...$adresses)
            ->subject(mb_strtoupper($object))
            //->priority(Email::PRIORITY_HIGH)
            //->text(strip_tags($message, ['br', 'p']));
            ->htmlTemplate('emails/'.$template)
            ->context([
                'message' => $message
            ]);
        try {
            $this->mailer->send($email);
            return true;
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
    }

    public function sendMuliple($message, $emails)
    {

    }
}
