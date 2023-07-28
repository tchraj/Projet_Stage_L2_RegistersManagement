<?php

namespace App\Repository;

use App\Entity\TypeVisiteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeVisiteur>
 *
 * @method TypeVisiteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeVisiteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeVisiteur[]    findAll()
 * @method TypeVisiteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeVisiteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeVisiteur::class);
    }

//    /**
//     * @return TypeVisiteur[] Returns an array of TypeVisiteur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeVisiteur
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
