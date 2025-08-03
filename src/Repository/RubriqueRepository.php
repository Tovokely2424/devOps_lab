<?php

namespace App\Repository;

use App\Entity\Rubrique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rubrique>
 */
class RubriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rubrique::class);
    }

    /**
     * 🔍 Récupère toutes les rubriques d’une grille donnée
     */
    public function findByGrille(int $grilleId): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.grille = :grilleId')
            ->setParameter('grilleId', $grilleId)
            ->orderBy('r.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * 🔍 Recherche une rubrique par son titre dans une grille donnée
     */
    public function findByTitreAndGrille(string $titre, int $grilleId): ?Rubrique
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.titre = :titre')
            ->andWhere('r.grille = :grille')
            ->setParameter('titre', $titre)
            ->setParameter('grille', $grilleId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
