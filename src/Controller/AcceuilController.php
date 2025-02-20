<?php

namespace App\Controller;

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use App\Entity\CompteUtilisateur;
use App\Repository\DirectionRepository;
use App\Repository\VisiteurExterneRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AcceuilController extends AbstractController
{
    private $directionRepository;
    private $visiteRepository;
    private $security;

    public function __construct(
        DirectionRepository $directionRepository,
        VisiteRepository $visiteRepository,
    ) {
        $this->directionRepository = $directionRepository;
        $this->visiteRepository = $visiteRepository;
    }

    #[Route('/acceuil', name: 'app_acceuil')]
    public function index(ManagerRegistry $managerRegistry, VisiteRepository $visiteRepository, VisiteurExterneRepository $visiteurExterneRepository): Response
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
        $anneeEnCours = date('Y');
        $visites = $visiteRepository->findByYear($anneeEnCours);

        $totalAcceptedVisits = 0;

        // Parcours des visites pour compter les acceptées
        foreach ($visites as $visite) {
            if ($visite->isEtatVisite()) {
                $totalAcceptedVisits++;
            }
        }
        $totalRefusedVisits = 0;

        // Parcours des visites pour compter les acceptées
        foreach ($visites as $visite) {
            if (!($visite->isEtatVisite())) {
                $totalRefusedVisits++;
            }
        }
        // Obtenez les visites de l'année en cours depuis la base de données
        // Initialisez un tableau pour stocker les statistiques par mois
        $statistiques = [];
        foreach ($visites as $visite) {
            $mois = $visite->getDateVisite()->format('F'); // Utilisez le nom complet du mois
            if (!isset($statistiques[$mois])) {
                $statistiques[$mois] = 1;
            } else {
                $statistiques[$mois]++;
            }
        }

        $statisticsByDepartment = $visiteRepository->countVisitsByDepartment();
        $totalVisiteurs = $visiteurExterneRepository->countTotalVisiteurs();
        $totalVisits = $visiteRepository->countTotalVisits();
        return $this->render('acceuil/index.html.twig', [
            'mois' => $month,
            'annee' => $yearInt,
            "visites" => count($visits),
            "visitsPerDay" => $visitsPerDay,
            'visitsPerMonth ' => $visitsPerMonth,
            'mostVisitedEmployees' => $mostVisitedEmployees,
            'employeeNames' => json_encode($employeeNames),
            'visitCounts' => json_encode($visitCounts),
            'statistiques' => $statistiques,
            'statisticsByDepartment' => $statisticsByDepartment,
            'totalVisits' => $totalVisits,
            'totalVisiteurs' => $totalVisiteurs,
            'totalAcceptedVisits' => $totalAcceptedVisits,
            'totalRefusedVisits' => $totalRefusedVisits
        ]);
    }

    // #[Route('/stats_direction', name: 'app_stats_dir')]
    // public function directionStatistiques(VisiteRepository $visiteRepository)
    // {
    //     $statistiquesParDirection = $visiteRepository->getMonthlyVisitStatisticsByDirection();
    //     return $this->render('acceuil/stats_direction.html.twig', [
    //         'statistiquesParDirection' => $statistiquesParDirection,
    //     ]);
    // }
    #[Route('/stats_departement', name: 'app_stats_dep')]
    public function departmentStatistiques(VisiteRepository $visiteRepository)
    {

        $user = $this->getUser();
        if ($user instanceof CompteUtilisateur) {
            // Récupérer l'employé associé au compte
            $employe = $user->getEmploye();
            // Vérifier si l'employé est présent
            if ($employe !== null) {
                $direction = $employe->getDirection();
                $directionId = $direction->getId();
                $responsable = $direction->getResponsable();
                $monthNames = [
                    1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                    5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                    9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                ];

                $data = $this->visiteRepository->findVisitsStatisticsAndListByDepartment($direction);
                return $this->render('acceuil/stats_pour_directeurs.html.twig', [
                    'statistiquesParDepartement' => $data['statistiques'],
                    'direction' => $direction->getNomDirection(),
                    'monthNames' => $monthNames,
                    'visitesParDirection' => $data['visites'],

                ]);
            }
        }
    }
}
