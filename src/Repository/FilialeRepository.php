<?php

namespace App\Repository;

use App\Entity\Filiale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Filiale>
 *
 * @method Filiale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Filiale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Filiale[]    findAll()
 * @method Filiale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilialeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Filiale::class);
    }

//    /**
//     * @return Filiale[] Returns an array of Filiale objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Filiale
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
