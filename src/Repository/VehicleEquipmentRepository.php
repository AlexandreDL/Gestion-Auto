<?php

namespace App\Repository;

use App\Entity\VehicleEquipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VehicleEquipment|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleEquipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleEquipment[]    findAll()
 * @method VehicleEquipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleEquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehicleEquipment::class);
    }

    // /**
    //  * @return VehicleEquipment[] Returns an array of VehicleEquipment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VehicleEquipment
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}