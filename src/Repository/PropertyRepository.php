<?php

namespace App\Repository;

use App\Entity\property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method property|null find($id, $lockMode = null, $lockVersion = null)
 * @method property|null findOneBy(array $criteria, array $orderBy = null)
 * @method property[]    findAll()
 * @method property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, property::class);
    }


    
/**
 * Undocumented function
 *
 * @return property[]
 */
    public function findAllVisible (): array
    {
        return $this->findVisibleQuery('p')
        ->Where('p.sold = false')
        ->getQuery()
        ->getResult();
    }

    /**
 * Undocumented function
 *
 * @return property[]
 */
public function findLatest (): array
{
    return $this->findVisibleQuery('p')
    ->setMaxResults(4)
    ->getQuery()
    ->getResult();
}


private function findVisibleQuery(): QueryBuilder
{
    return $this->createQueryBuilder('p')
    ->where('p.sold = false');
}



    // /**
    //  * @return property[] Returns an array of property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
