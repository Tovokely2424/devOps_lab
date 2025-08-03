<?php

namespace App\Entity;

use App\Repository\EvaluationScoreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EvaluationScoreRepository")
 * @ORM\Table(name="evaluation_score")
 */
class EvaluationScore
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    private int $id;

    // 🔗 Relation: Many Scores → One Evaluation
    #[ORM\ManyToOne(targetEntity: Evaluation::class, inversedBy: 'scores')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Evaluation $evaluation = null;

    // 🔗 Relation: Many Scores → One Critere
    #[ORM\ManyToOne(targetEntity: Critere::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Critere $critere = null;

    // ✅ Score attribué pour ce critère
    #[ORM\Column(type: 'integer')]
    #[Assert\NotNull]
    #[Assert\Range(min: 0, max: 10, notInRangeMessage: 'Le score doit être entre {{ min }} et {{ max }}.')]
    private ?int $score = null;

    // ✅ Commentaire optionnel pour ce critère
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $commentaire = null;

    // --------------- Getters / Setters ---------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvaluation(): ?Evaluation
    {
        return $this->evaluation;
    }

    public function setEvaluation(?Evaluation $evaluation): self
    {
        $this->evaluation = $evaluation;
        return $this;
    }

    public function getCritere(): ?Critere
    {
        return $this->critere;
    }

    public function setCritere(?Critere $critere): self
    {
        $this->critere = $critere;
        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;
        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;
        return $this;
    }
}
