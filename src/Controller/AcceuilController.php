<?php

namespace App\Controller;

use App\Entity\Employe;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/acceuil')]
class AcceuilController extends AbstractController
{
    #[Route('/', name: 'app_acceuil')]
    public function index(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $employes = $managerRegistry->getRepository(Employe::class)->findAll();
        return $this->render('acceuil/index.html.twig', [
            'employes' => $employes,
        ]);
    }
    // #[Route('/', name: 'app_nombre_visite')]
    // public function nombreVisite()
    // {
    //     $user = $this->getUser(); // Récupère l'objet User de l'utilisateur connecté

    //     if ($user) {
    //         $employe = $user->get // Récupère l'employé associé à l'utilisateur connecté

    //         if ($employe) {
    //             $nombreVisites = $employe->getVisiteEffectuees()->count();
    //         } else {
    //             // L'utilisateur n'a pas d'employé associé, gérer le cas si nécessaire
    //             $nombreVisites = 0;
    //         }
    //     } else {
    //         // L'utilisateur n'est pas connecté, gérer le cas si nécessaire
    //         $nombreVisites = 0;
    //     }

    //     return $this->render('acceuil.html.twig', [
    //         'nombreVisites' => $nombreVisites,
    //     ]);
    // }
}
