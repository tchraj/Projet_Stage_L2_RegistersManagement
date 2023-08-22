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
class AdminController extends AbstractController
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

    #[Route('/acceuil', name: 'app_admin')]
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
        $totalAcceptedVisits = 0;

        // Parcours des visites pour compter les acceptées
        foreach ($visites as $visite) {
            if ($visite->getEtatVisite()) {
                $totalAcceptedVisits++;
            }
        }
        $statisticsByDepartment = $visiteRepository->countVisitsByDepartment();
        $totalVisiteurs = $visiteurExterneRepository->countTotalVisiteurs();
        $totalVisits = $visiteRepository->countTotalVisits();
        return $this->render('admin/admin.html.twig', [
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
            'totalAcceptedVisits' => $totalAcceptedVisits

        ]);
    }
    #[Route('/stats_departement', name: 'app_stats_dep')]
    public function departmentStatistiques(VisiteRepository $visiteRepository, DirectionRepository $directionRepository)
    {
        $user = $this->getUser();
        if ($user instanceof CompteUtilisateur) {
            // Récupérer l'employé associé au compte
            $employe = $user->getEmploye();
            // Vérifier si l'employé est présent
            if ($employe !== null) {
                $direction = $employe->getDirection();
                $visitesParDirection = $visiteRepository->findVisitsByDirection($direction);
                $directionId = $direction->getId();
                $responsable = $direction->getResponsable();
                $monthNames = [
                    1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                    5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                    9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                ];
                $statistiquesParMois = [];
                foreach ($visitesParDirection as $visite) {
                    $dateVisite = $visite->getDateVisite(); // Supposons que cette méthode retourne un objet DateTime
                    $mois = $dateVisite->format('n'); // 'n' pour le numéro du mois sans le zéro initial
                    $nombreVisites = 1; // Vous pouvez également compter les visites par mois ici
                    if (isset($statistiquesParMois[$mois])) {
                        $statistiquesParMois[$mois]['nombreVisites'] += $nombreVisites;
                    } else {
                        $statistiquesParMois[$mois] = [
                            'mois' => $mois,
                            'nombreVisites' => $nombreVisites
                        ];
                    }
                }
                $limit = 3; // Limite le nombre d'employés affichés
                //$mostVisitedEmployees = $visiteRepository->findMostVisitedEmployeesWithCounts($limit);
                $direction = $directionRepository->find($directionId);
                $mostVisitedEmployeesInDirection = $visiteRepository->findByMostVisitedEmployeesInDirection($direction, $limit);

                return $this->render('acceuil/stats_pour_directeurs.html.twig', [
                    'statistiquesParDepartement' => $statistiquesParMois,
                    'direction' => $direction->getNomDirection(),
                    'monthNames' => $monthNames,
                    'visitesParDirection' => $visitesParDirection,
                    //'mostVisitedEmployees' => $mostVisitedEmployees,
                    'mostVisitedEmployeesInDirection' => $mostVisitedEmployeesInDirection
                ]);
            }
        }
    }
}
