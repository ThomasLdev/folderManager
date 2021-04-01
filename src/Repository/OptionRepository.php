<?php

namespace App\Repository;

use App\Entity\Option;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Option|null find($id, $lockMode = null, $lockVersion = null)
 * @method Option|null findOneBy(array $criteria, array $orderBy = null)
 * @method Option[]    findAll()
 * @method Option[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Option::class);
    }

    public function findDistinctByType(string $type)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.type = :type and p.value != :null')
            ->setParameter('type', $type)
            ->setParameter('null', '')
            ->groupBy('p.value')
            ->orderBy('p.type', 'ASC');


        $query = $qb->getQuery();

        return $query->execute();
    }

    public function findOneByValueAndType(string $type, $value)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.type = :type and p.value = :value')
            ->setParameter('type', $type)
            ->setParameter('value', $value);

        $query = $qb->getQuery();

        return $query->setMaxResults(1)->getOneOrNullResult();
    }

    // /**
    //  * @return Option[] Returns an array of Option objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Option
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
