<?php

namespace App\Repository;

use App\Entity\NorlogFolder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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

//	/**
//	 * @param $norlogFolders
//	 * @return Query
//	 */
//	public function paginateNorlogFolders($norlogFolders): Query
//	{
//		return $this->createQueryBuilder('n')
//			->orderBy('n.norlogReference', 'ASC')
//			->getQuery();
//	}
}
