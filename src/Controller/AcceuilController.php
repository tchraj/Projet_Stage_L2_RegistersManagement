<?php

namespace App\Controller;

use App\Entity\Visite;
use App\Entity\Employe;
use App\Repository\VisiteRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class AcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'app_acceuil')]
    public function index(ManagerRegistry $managerRegistry, VisiteRepository $visiteRepository,): Response
    {
        $year = new DateTime('today');
        $yearInt = (int)$year->format('Y');
        $visites = $managerRegistry->getRepository(Visite::class)->findAll();
        foreach ($visites as $visite) {
            $month = $visite->getDateVisite()->format('m');
        }
        $visits = $visiteRepository->findVisitsByMonth($yearInt, $month);
        $visitsPerDay = array_fill(1, cal_days_in_month(CAL_GREGORIAN, $month, $yearInt), 0);
        foreach ($visits as $visit) {
            $day = $visit->getDateVisite()->format('j');
            $visitsPerDay[$day]++;
        }
        $visitsPerMonth = array_fill(1, 12, 0);
        foreach ($visits as $visit) {
            $visitMonth = (int)$month;
            $visitsPerMonth[$visitMonth]++;
        }

        $mostVisitedEmployees = $visiteRepository->countVisitsByEmployee();
        $employeeNames = [];
        $visitCounts = [];
        foreach ($mostVisitedEmployees as $employeeData) {
            $employeeNames[] = $employeeData['name'] . " " . $employeeData['firstname'];
            $visitCounts[] = $employeeData['count'];
        }
        //$totalVisites = $visiteRepository->countVisitsPerMonth($year);
        return $this->render('acceuil/index.html.twig', [
            'mois' => $month,
            'annee' => $yearInt,
            "visites" => count($visits),
            "visitsPerDay" => $visitsPerDay,
            'visitsPerMonth ' => $visitsPerMonth,
            'mostVisitedEmployees' => $mostVisitedEmployees,
            'employeeNames' => json_encode($employeeNames),
            'visitCounts' => json_encode($visitCounts),

            //'total'  => $totalVisites
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
