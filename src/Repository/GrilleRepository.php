<?php

namespace App\Repository;

use App\Entity\Grille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Grille>
 */
class GrilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grille::class);
    }

    /**
     * 🔍 Récupère toutes les grilles triées par titre
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('g')
            ->orderBy('g.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * 🔍 Recherche une grille par son titre (utile pour éviter les doublons)
     */
    public function findByTitre(string $titre): ?Grille
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.titre = :titre')
            ->setParameter('titre', $titre)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * 🔍 Récupère toutes les grilles qui contiennent au moins une rubrique
     */
    public function findGrillesWithRubriques(): array
    {
        return $this->createQueryBuilder('g')
            ->join('g.rubriques', 'r')
            ->addSelect('r')
            ->getQuery()
            ->getResult();
    }
}
