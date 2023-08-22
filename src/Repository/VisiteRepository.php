<?php

namespace App\Repository;

use Doctrine\ORM\Query\Expr;
use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 *
 * @method Visite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visite[]    findAll()
 * @method Visite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

    //    /**
    //     * @return Visite[] Returns an array of Visite objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }
    // 
    public function findOneByTypeVisiteur($typeVisiteur): ?Visite
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.typeVisiteur = :val')
            ->setParameter('val', $typeVisiteur)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function findOneById($id): ?Visite
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function findVisitsByMonth($year, $month)
    {
        $DateDebut = new \DateTime("$year-$month-01");
        $DateFin = clone $DateDebut;
        $DateFin->modify('last day of this month');

        return $this->createQueryBuilder('v')
            ->where('v.DateVisite BETWEEN :DateDebut AND :DateFin')
            ->setParameter('DateDebut', $DateDebut)
            ->setParameter('DateFin', $DateFin)
            ->getQuery()
            ->getResult();
    }
    public function getMonthFromDate(\DateTime $date)
    {
        return (int)$date->format('m');
    }
    // public function countVisitsPerMonth($year)
    // {
    //     return $this->createQueryBuilder('v')
    //         ->select('v.DateVisite as visitDate, COUNT(v) as count')
    //         ->where('DATE_FORMAT(v.DateVisite, \'%Y\') = :year')
    //         ->groupBy('visitDate')
    //         ->setParameter('year', $year)
    //         ->getQuery()
    //         ->getResult();
    // }
    public function countVisitsByEmployee()
    {
        return $this->createQueryBuilder('v')
            ->select('e.nom as name,e.prenoms as firstname',  'COUNT(v) as count')
            ->join('v.EmployeVisite', 'e')
            ->groupBy('e')
            ->orderBy('count', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function getAllVisits()
    {
        return $this->createQueryBuilder('v')
            ->select('v', 'e', 'd')
            ->join('v.EmployeVisite', 'e')
            ->join('e.direction', 'd')
            ->getQuery()
            ->getResult();
    }

    public function countVisitsByDepartment()
    {
        $allVisits = $this->getAllVisits();
        $currentYear = date('Y'); // Obtenez l'année en cours

        $statisticsByDepartment = [];

        foreach ($allVisits as $visit) {
            $visitYear = $visit->getDateVisite()->format('Y');

            if ($visitYear === $currentYear) {
                $departmentName = $visit->getEmployeVisite()->getDirection()->getNomDirection();
                if (!isset($statisticsByDepartment[$departmentName])) {
                    $statisticsByDepartment[$departmentName] = 1;
                } else {
                    $statisticsByDepartment[$departmentName]++;
                }
            }
        }

        arsort($statisticsByDepartment); // Triez par ordre décroissant

        return $statisticsByDepartment;
    }

    public function findByYear($year)
    {
        $startDate = new \DateTime($year . '-01-01');
        $endDate = new \DateTime($year . '-12-31');
        return $this->createQueryBuilder('v')
            ->where('v.DateVisite >= :startDate')
            ->andWhere('v.DateVisite <= :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();
    }
    public function countTotalVisits()
    {
        return $this->createQueryBuilder('v')
            ->select('COUNT(v) as total')
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function findVisitsByDirection($direction)
    {
        return $this->createQueryBuilder('v')
            ->join('v.EmployeVisite', 'e')
            ->where('e.direction = :direction')
            ->setParameter('direction', $direction)
            ->getQuery()
            ->getResult();
    }

    public function findVisitsStatisticsAndListByDepartment($direction)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery("
            SELECT
                MONTH(v.dateVisite) AS mois,
                COUNT(v.id) AS nombreVisites
            FROM
                App\Entity\Visite v
            WHERE
                v.EmployeVisite IN (
                    SELECT e.id FROM App\Entity\Employe e WHERE e.direction = :direction
                )
            GROUP BY
                mois
            ORDER BY
                mois ASC
        ")->setParameter('direction', $direction);

        $statistiques = $query->getResult();

        $visites = $this->createQueryBuilder('v')
            ->join('v.EmployeVisite', 'e')
            ->where('e.direction = :direction')
            ->setParameter('direction', $direction)
            ->getQuery()
            ->getResult();

        return ['statistiques' => $statistiques, 'visites' => $visites];
    }
    public function findAllSortedByCreationDateDesc()
    {
        return $this->createQueryBuilder('v')
            ->orderBy('v.DateVisite', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function findByMostVisitedEmployeesInDirection($direction, $limit)
{
    return $this->createQueryBuilder('v')
        ->select('e.nom', 'e.prenoms', 'COUNT(v) as count')
        ->join('v.EmployeVisite', 'e')
        ->where('e.direction = :direction')
        ->setParameter('direction', $direction)
        ->groupBy('e.nom', 'e.prenoms')
        ->orderBy('count', 'DESC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}

}
