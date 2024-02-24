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
     
         
         $qb->leftJoin('c.Id_Livre', 'p')// Ajoute des jointures nécessaires
            ->addSelect('p'); // Sélectionne également les champs de l'entité jointe
     
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

    
}