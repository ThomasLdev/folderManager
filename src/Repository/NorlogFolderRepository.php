<?php

namespace App\Repository;

use App\Entity\NorlogFolder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NorlogFolder|null find($id, $lockMode = null, $lockVersion = null)
 * @method NorlogFolder|null findOneBy(array $criteria, array $orderBy = null)
 * @method NorlogFolder[]    findAll()
 * @method NorlogFolder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NorlogFolderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NorlogFolder::class);
    }

    // /**
    //  * @return NorlogFolder[] Returns an array of NorlogFolder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NorlogFolder
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
