<?php
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Employe;

class AppAdmin
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function getEmployeeWithMostReceivedVisits(): ?Employe
    {
        $employeeRepository = $this->entityManager->getRepository(Employe::class);
        return $employeeRepository->createQueryBuilder('e')
            ->leftJoin('e.VisiteRecue', 'v')
            ->addSelect('COUNT(v) as visitCount')
            ->groupBy('e.id')
            ->orderBy('visitCount', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getEmployeeWithLeastReceivedVisits(): ?Employe
    {
        $employeeRepository = $this->entityManager->getRepository(Employe::class);
        return $employeeRepository->createQueryBuilder('e')
            ->leftJoin('e.VisiteRecue', 'v')
            ->addSelect('COUNT(v) as visitCount')
            ->groupBy('e.id')
            ->orderBy('visitCount', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getTotalVisitsByMonth(): array
    {
        $employeeRepository = $this->entityManager->getRepository(Employe::class);
        $employees = $employeeRepository->findAll();

        $totalVisitsByMonth = [];
        foreach ($employees as $employee) {
            $visitsByMonth = [];
            $visits = $employee->getVisiteRecue();
            
            foreach ($visits as $visit) {
                $month = $visit->getDateVisite()->format('m-Y');
                if (!isset($visitsByMonth[$month])) {
                    $visitsByMonth[$month] = 0;
                }
                $visitsByMonth[$month]++;
            }

            $totalVisitsByMonth[$employee->getId()] = $visitsByMonth;
        }
        return $totalVisitsByMonth;
    }
}
