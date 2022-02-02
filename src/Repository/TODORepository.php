<?php

namespace App\Repository;

use App\Entity\TODO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TODO|null find($id, $lockMode = null, $lockVersion = null)
 * @method TODO|null findOneBy(array $criteria, array $orderBy = null)
 * @method TODO[]    findAll()
 * @method TODO[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TODORepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TODO::class);
    }
}
