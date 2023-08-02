<?php

namespace App\Repository;

use App\Entity\Employe;
use App\Models\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * @extends ServiceEntityRepository<Employe>
 *
 * @method Employe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employe[]    findAll()
 * @method Employe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employe::class);
    }

    //    /**
    //     * @return Employe[] Returns an array of Employe objects
    //     */
    public function findByNom($nom): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nom LIKE :val')
            ->setParameter('val', $nom)
            //->orderBy('e.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findOneById($id): ?Employe
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findBySearch(SearchData $search): Response
    {
        $data = $this->createQueryBuilder('a')
            ->andWhere('p.state LIKE : state')
            ->setParameter('state', '%STATE_PUBLISHED%')
            ->OrderBy('p.id', 'DESC');
        if (!empty($search->q)) {
            $data = $data
                ->andWhere('p.nom LIKE : q')
                ->setParameter('q', "%{ $search->q }%");
            $data = $data
                ->getQuery()
                ->getResult();
            //$employes2 = $this->$paginatorInterface->paginate($data, $search->page, 9);
            return $data;
        }
    }
}
