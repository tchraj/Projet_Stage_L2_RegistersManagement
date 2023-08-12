<?php

namespace App\Repository;

use App\Entity\VisiteurExterne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VisiteurExterne>
 *
 * @method VisiteurExterne|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisiteurExterne|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisiteurExterne[]    findAll()
 * @method VisiteurExterne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteurExterneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisiteurExterne::class);
    }
    /*
    public function findForPagination(){
        $qb = $this->createQueryBuilder('v')
        ->orderBy('v.nom','DESC')
        ;
    }*/
//    /**
//     * @return VisiteurExterne[] Returns an array of VisiteurExterne objects
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

//    public function findOneBySomeField($value): ?VisiteurExterne
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
