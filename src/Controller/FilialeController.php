<?php

namespace App\Controller;

use App\Entity\Filiale;
use App\Form\FilialeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/filiale')]
class FilialeController extends AbstractController
{
    #[Route('/', name: 'app_filiale')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $filiales = $managerRegistry->getRepository(Filiale::class)->findAll();
        return $this->render('filiale/index.html.twig', [
            'filiales' => $filiales
        ]);
    }
    #[Route('/add', name: 'app_add_filiale')]
    public function AddFiliale(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $entityManager = $managerRegistry->getManager();
        $filiale = new Filiale();
        $form = $this->createForm(FilialeType::class, $filiale);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($filiale);
            $manager->flush();
            $this->addFlash("Succes", "Filiale ajouté avec succes!");
            return $this->redirectToRoute('app_filiale');
        } else
            return $this->render('filiale/add.html.twig', [
                'FilialeForm' => $form->createView()
            ]);
    }
    #[Route('/update/{id}', name: 'app_update_filiale')]
    public function updatePiece(Filiale $fil, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $form = $this->createForm(FilialeType::class, $fil);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $fil = $form->getData();
            $manager->persist($fil);
            $manager->flush();
            return $this->redirectToRoute('app_filiale');
        } else
            return $this->render('filiale/add.html.twig', [
                'FilialeForm' => $form->createView()
            ]);
    }
}
