<?php

namespace App\Repository;

use App\Entity\TypePiece;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypePiece>
 *
 * @method TypePiece|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypePiece|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypePiece[]    findAll()
 * @method TypePiece[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypePieceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypePiece::class);
    }

//    /**
//     * @return TypePiece[] Returns an array of TypePiece objects
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

//    public function findOneBySomeField($value): ?TypePiece
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
