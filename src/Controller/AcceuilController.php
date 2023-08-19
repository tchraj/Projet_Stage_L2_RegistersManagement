<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Repository\VisiteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class AcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'app_acceuil')]
    public function index(ManagerRegistry $managerRegistry,VisiteRepository $visiteRepository,): Response
    {
        $dailyVisits = $visiteRepository->findAll();
        $labels = [];
        $data = [];
        foreach ($dailyVisits as $dailyVisit) {
            $labels[] =$dailyVisit->getDateVisite()->format('d/m/Y');
            $data[] =$dailyVisit->getEmployeVisite()->getNomComplet();
        }
        $employes = $managerRegistry->getRepository(Employe::class)->findAll();
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_dashboard'); // Remplacez 'app_dashboard' par la route de votre page d'accueil
        }
        return $this->render('acceuil/index.html.twig', [
            'employes' => $employes,
        ]);
    }

    #[Route('/infos_employes', name: 'app_infos_employe')]
    public function infosEmployes(Employe $employe, ManagerRegistry $managerRegistry)
    {
        $manager = $managerRegistry->getManager();
        $employes = $manager->getRepository(Employe::class)->findAll();
        return $this->redirectToRoute('app_acceuil', [
            'employes' => $employes
        ]);
    }
}
