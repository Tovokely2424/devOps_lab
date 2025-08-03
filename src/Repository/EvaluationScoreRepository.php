<?php

namespace App\Repository;

use App\Entity\EvaluationScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EvaluationScore>
 */
class EvaluationScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvaluationScore::class);
    }

    /**
     * 🔍 Récupère tous les scores d’une évaluation
     */
    public function findByEvaluation(int $evaluationId): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.evaluation = :eval')
            ->setParameter('eval', $evaluationId)
            ->getQuery()
            ->getResult();
    }

    /**
     * 🔍 Calcule la somme des scores pour une évaluation donnée
     */
    public function getTotalScoreForEvaluation(int $evaluationId): ?float
    {
        return $this->createQueryBuilder('s')
            ->select('SUM(s.score) as totalScore')
            ->andWhere('s.evaluation = :eval')
            ->setParameter('eval', $evaluationId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
