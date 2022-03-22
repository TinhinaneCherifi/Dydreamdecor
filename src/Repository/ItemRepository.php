<?php

namespace App\Repository;

use App\Entity\Item;
use App\Service\Filter;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    /**
     * This function finds the items depending on the user's research
     * @return Item[] 
     */
    public function findByFilter(Filter $filter)
    {
        $query = $this
            ->createQueryBuilder('i')
            ->select('ic', 'i')
            ->join('i.category', 'ic');

            if (!empty($filter->itemCategories)){
                $query = $query
                ->andWhere('ic.id IN (:itemCategories)')/** we want to put ItemCategory ids in itemCategories */
                ->setParameter('itemCategories', $filter->itemCategories);
            }

            if (!empty($filter->itemString)){
                $query = $query
                ->andWhere('i.name LIKE :itemString')/** we want to compare name in Item with the string in the input */
                ->setParameter('itemString', "%{$filter->itemString}%"); /** percentage symbol means that we need a partial research */
            }

            return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Item[] Returns an array of Item objects
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
    public function findOneBySomeField($value): ?Item
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
