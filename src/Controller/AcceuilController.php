<?php

namespace App\Controller;

use App\Entity\Employe;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
}
