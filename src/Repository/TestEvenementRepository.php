<?php

namespace App\Repository;

use App\Entity\TestEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestEvenement>
 *
 * @method TestEvenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestEvenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestEvenement[]    findAll()
 * @method TestEvenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestEvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestEvenement::class);
    }

//    /**
//     * @return TestEvenement[] Returns an array of TestEvenement objects
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

//    public function findOneBySomeField($value): ?TestEvenement
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
