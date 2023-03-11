<?php

namespace App\Repository;

use App\Entity\Inspiration;
use App\Service\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inspiration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inspiration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inspiration[]    findAll()
 * @method Inspiration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InspirationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inspiration::class);
    }

    /**
     * This function finds the inspirations depending on the user's research
     * @return Inspiration[] 
     */
    public function findBySearch(Search $search)
    {
        $query = $this
            ->createQueryBuilder('inspi')
            ->select('inspicat', 'inspi')
            ->join('inspi.category', 'inspicat');

            if (!empty($search->inspirationCategories)){
                $query = $query
                ->andWhere('inspicat.id IN (:inspirationCategories)')
                ->setParameter('inspirationCategories', $search->inspirationCategories);
            }

            if (!empty($search->inspirationString)){
                $query = $query
                ->andWhere('inspi.title LIKE :inspirationString')/** we want to compare name in Inspiration with the string in the input */
                ->setParameter('inspirationString', "%{$search->inspirationString}%"); /** percentage symbol means that we need a partial research */
            }

            return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Item[] Returns an array of Inspiration objects
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
    public function findOneBySomeField($value): ?Inspiration
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
