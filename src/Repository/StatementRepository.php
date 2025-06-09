<?php

namespace App\Repository;

use App\Entity\Statement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Statement>
 */
class StatementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statement::class);
    }
    /**
     * @return Statement[] Returns an array of Statement objects
     */
    public function getLast($idProduct): array
    {

        $qb = $this->createQueryBuilder('s');

        $subQb = $this->createQueryBuilder('s2');
        $subQb->select('MAX(s2.dateinput)')
            ->where('s2.ensign = s.ensign')
            ->andWhere('s2.product = :val');

        $qb->select('s')
            ->where(
                $qb->expr()->eq(
                    's.dateinput',
                    '(' . $subQb->getDQL() . ')'
                )
            )->andWhere('s.product = :val')
            ->setParameter('val', $idProduct);

        $results = $qb->getQuery()->getResult();
        return $results;
    }


    //    /**
    //     * @return Statement[] Returns an array of Bank objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Statement
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
