<?php

namespace App\Repository;

use App\Entity\DailyReport;
use App\Entity\MonthlyReport;
use App\Entity\WeeklyReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MonthlyReport>
 *
 * @method MonthlyReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonthlyReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonthlyReport[]    findAll()
 * @method MonthlyReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonthlyReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonthlyReport::class);
    }

    public function getReportList(array $action)
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.'.$action['orderField'], $action['order'])
            ->getQuery()
            ->getResult();
    }

    public function getProceed()
    {
        return $this->createQueryBuilder('r')
            ->select('SUM(r.total_price) as proceed')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(MonthlyReport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MonthlyReport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DailyReport[] Returns an array of DailyReport objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DailyReport
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
