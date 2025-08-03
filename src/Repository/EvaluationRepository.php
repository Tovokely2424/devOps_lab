<?php

namespace App\Repository;

use App\Entity\Evaluation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evaluation>
 */
class EvaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evaluation::class);
    }

    /**
     * 🔍 Récupère toutes les évaluations d’un appel donné
     */
    public function findByCall(int $callId): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.call = :callId')
            ->setParameter('callId', $callId)
            ->orderBy('e.dateEvaluation', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * 🔍 Récupère toutes les évaluations effectuées par un contrôleur qualité donné
     */
    public function findByControleur(int $controleurId): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.controleur = :ctrl')
            ->setParameter('ctrl', $controleurId)
            ->orderBy('e.dateEvaluation', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * 🔍 Calcule la note moyenne sur toutes les évaluations d’un agent
     */
    public function getAverageScoreByAgent(int $agentId): ?float
    {
        return $this->createQueryBuilder('e')
            ->select('AVG(e.noteTotale) as avgScore')
            ->join('e.call', 'c')
            ->andWhere('c.agent = :agent')
            ->setParameter('agent', $agentId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
