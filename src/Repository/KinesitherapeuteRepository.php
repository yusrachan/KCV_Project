<?php

namespace App\Repository;

use App\Entity\Kinesitherapeute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Kinesitherapeute>
 *
 * @method Kinesitherapeute|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kinesitherapeute|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kinesitherapeute[]    findAll()
 * @method Kinesitherapeute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KinesitherapeuteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kinesitherapeute::class);
    }

//    /**
//     * @return Kinesitherapeute[] Returns an array of Kinesitherapeute objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('k.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Kinesitherapeute
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
