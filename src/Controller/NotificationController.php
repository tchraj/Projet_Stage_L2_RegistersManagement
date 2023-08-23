<?php

namespace App\Controller;

use App\Form\NotificationType;
use App\Entity\Notification;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'messages')]
    public function index(): Response
    {
        return $this->render('notification/index.html.twig');
    }
    #[Route('/send', name: 'send')]

    public function send(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $message = new Notification;
        $form = $this->createForm(NotificationType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());

            $manager = $managerRegistry->getManager();
            $date = new DateTimeImmutable('today');
            $message->setCreatedAt($date);
            $manager->persist($message);
            $manager->flush();

            $this->addFlash("message", "Message envoyé avec succès.");
            return $this->redirectToRoute("messages");
        }

        return $this->render("notification/send.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route('/received', name: 'received')]

    public function received(): Response
    {
        return $this->render('notification/received.html.twig');
    }


    #[Route('/sent', name: 'sent')]

    public function sent(): Response
    {
        return $this->render('notification/sent.html.twig');
    }

    #[Route('/read/{id}', name: 'read')]

    public function read(Notification $message, ManagerRegistry $managerRegistry): Response
    {
        $message->setIsRead(true);
        $manager = $managerRegistry->getManager();
        $manager->persist($message);
        $manager->flush();

        return $this->render('notification/read.html.twig', compact("message"));
    }

    #[Route('/delete/{id}', name: 'delete')]

    public function delete(Notification $message, ManagerRegistry $managerRegistry): Response
    {
        $manager = $managerRegistry->getManager();
        $manager->remove($message);
        $manager->flush();

        return $this->redirectToRoute("received");
    }
}
