<?php

namespace App\Repository;

use App\Entity\Commander;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Commander>
 *
 * @method Commander|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commander|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commander[]    findAll()
 * @method Commander[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommanderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commander::class);
    }


    /**
     * @param \DateTimeInterface $date
     * @return Commander[]
     */
    
     public function findAllCommandesWithJointures()
     {
         // Crée un QueryBuilder avec l'alias 'c' pour les commandes
         $qb = $this->createQueryBuilder('c');
     
         // Ajoute les jointures nécessaires, par exemple avec une entité 'Produit'
         $qb->leftJoin('c.produit', 'p')
            ->addSelect('p'); // Sélectionne également les champs de l'entité jointe
     
         // Ajoute d'autres jointures au besoin...
     
         // Retourne le résultat de la requête
         return $qb->getQuery()->getResult();
     }
     

    public function findCommandesByDate(\DateTimeInterface $date): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.dateachat = :date')
            ->setParameter('date', $date->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Commander[] Returns an array of Commander objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Commander
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}