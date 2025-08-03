<?php

namespace App\Repository;

use App\Entity\Critere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Critere>
 */
class CritereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Critere::class);
    }

    /**
     * 🔍 Récupère tous les critères d’une rubrique donnée
     */
    public function findByRubrique(int $rubriqueId): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.rubrique = :rubriqueId')
            ->setParameter('rubriqueId', $rubriqueId)
            ->orderBy('c.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * 🔍 Recherche un critère par son titre dans une rubrique
     */
    public function findByTitreAndRubrique(string $titre, int $rubriqueId): ?Critere
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.titre = :titre')
            ->andWhere('c.rubrique = :rubrique')
            ->setParameter('titre', $titre)
            ->setParameter('rubrique', $rubriqueId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * 🔍 Compte le nombre de critères dans une rubrique
     */
    public function countByRubrique(int $rubriqueId): int
    {
        return (int) $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->andWhere('c.rubrique = :rubrique')
            ->setParameter('rubrique', $rubriqueId)
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function findByGrille($grille): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.rubrique', 'r')
            ->andWhere('r.grille = :grille')
            ->setParameter('grille', $grille)
            ->getQuery()
            ->getResult();
    }
}
