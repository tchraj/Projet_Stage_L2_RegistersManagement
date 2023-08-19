<?php

namespace App\Controller;

use App\Entity\Visite;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    private $statisticService;
    #[Route('/stats', name: 'app_stat')]

    public function statistiques(ManagerRegistry $managerRegistry)
    {
        $visites = $managerRegistry->getRepository(Visite::class)->findAll();
        $dateVisite = [];
        $motifVisite = [];
        $visiteur = [];
        return $this->render('admin/stats.html.twig');
    }
}
