<?php

namespace App\Controller;

use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfilsController extends AbstractController
{
    #[Route('/api/profils', name: 'profils')]
    public function index(Request $request, ProfilRepository $profilRepository)
    {
        return $this->json($profilRepository->search($request->query->get('e')));
    }
}
