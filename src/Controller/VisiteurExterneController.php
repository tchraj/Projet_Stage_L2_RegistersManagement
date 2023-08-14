<?php

namespace App\Controller;

use App\Entity\VisiteurExterne;
use App\Form\VisiteurExterneType;
use App\Entity\Visite;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/visiteur_externe')]
class VisiteurExterneController extends AbstractController
{
    #[Route('/', name: 'app_visiteur_externe')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $manager = $managerRegistry->getManager();
        $visiteurs = $manager->getRepository(VisiteurExterne::class)->findAll();

        return $this->render('visiteur_externe/index.html.twig', [
            'visiteurs' => $visiteurs
        ]);
    }
    #[Route('/add', name: 'app_add_visiteur')]
    public function addVisiteurExterne(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $entityManager = $managerRegistry->getManager();
        $visiteur = new VisiteurExterne();
        $form = $this->createForm(VisiteurExterneType::class, $visiteur);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($visiteur);
            $manager->flush();
            return $this->redirectToRoute('app_visiteur_externe');
        } else
            return $this->render('visiteur_externe/add.html.twig', [
                'VisiteurForm' => $form->createView()
            ]);
    }
    #[Route('/update/{id}', name: 'app_update_visiteur')]
    public function updatePiece(VisiteurExterne $visiteur, ManagerRegistry $managerRegistry, Request $request): Response
    {
        //$piece = $managerRegistry->getRepository(TypePiece::class, $piece);
        $form = $this->createForm(VisiteurExterneType::class, $visiteur);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $visiteur = $form->getData();
            $manager->persist($visiteur);
            $manager->flush();
            return $this->redirectToRoute('app_visiteur_externe');;
        } else
            return $this->render('visiteur_externe/update.html.twig', [
                'VisiteurForm' => $form->createView()
            ]);
    }
}
