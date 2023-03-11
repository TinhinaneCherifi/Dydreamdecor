<?php

namespace App\Repository;

use App\Entity\InspirationCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InspirationCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method InspirationCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method InspirationCategory[]    findAll()
 * @method InspirationCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InspirationCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InspirationCategory::class);
    }

    // /**
    //  * @return InspirationCategory[] Returns an array of InspirationCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InspirationCategory
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
