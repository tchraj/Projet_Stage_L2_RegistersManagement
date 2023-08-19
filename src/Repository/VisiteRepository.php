<?php

namespace App\Repository;

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
}
