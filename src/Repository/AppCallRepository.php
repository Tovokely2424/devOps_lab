<?php

namespace App\Repository;

use App\Entity\AppCall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppCall>
 */
class AppCallRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppCall::class);
    }

    /**
     * 🔍 Récupère tous les appels d’un agent spécifique
     */
    public function findByAgent(int $agentId): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.agent = :agentId')
            ->setParameter('agentId', $agentId)
            ->orderBy('c.dateAppel', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * 🔍 Récupère les appels qui n’ont pas encore été évalués
     */
    public function findPendingCalls(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.status = :status')
            ->setParameter('status', 'pending')
            ->getQuery()
            ->getResult();
    }
}
