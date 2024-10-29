<?php

namespace App\Repository;

use App\Entity\MkConn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MkConn>
 *
 * @method MkConn|null find($id, $lockMode = null, $lockVersion = null)
 * @method MkConn|null findOneBy(array $criteria, array $orderBy = null)
 * @method MkConn[]    findAll()
 * @method MkConn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MkConnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MkConn::class);
    }

//    /**
//     * @return MkConn[] Returns an array of MkConn objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MkConn
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
