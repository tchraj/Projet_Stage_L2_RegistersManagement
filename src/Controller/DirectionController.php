<?php

namespace App\Controller;

use App\Entity\Direction;
use App\Form\DirectionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class DirectionController extends AbstractController
{
    #[Route('/direction', name: 'app_direction')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $directions = $managerRegistry->getRepository(Direction::class)->findAll();
        return $this->render('direction/index.html.twig', [
            'directions' => $directions
        ]);
    }
    #[Route('/add_direction', name: 'app_add_direction')]
    public function AddDirection(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $entityManager = $managerRegistry->getManager();
        $direction = new Direction();
        $form = $this->createForm(DirectionType::class, $direction);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($direction);
            $manager->flush();
            $this->addFlash("Succes", "Visiteur ajouté avec succes!");
            return $this->redirectToRoute('app_direction');
        } else
            return $this->render('direction/add.html.twig', [
                'DirectionForm' => $form->createView()
            ]);
    }
    #[Route('/update_direction/{id}', name: 'app_update_direction')]
    public function updatePiece(Direction $direction, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $form = $this->createForm(DirectionType::class, $direction);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $piece = $form->getData();
            $manager->persist($direction);
            $manager->flush();
            return $this->redirectToRoute('app_direction');;
        } else
            return $this->render('direction/add.html.twig', [
                'DirectionForm' => $form->createView()
            ]);
    }
}
