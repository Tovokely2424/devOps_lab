<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\AppCall;
use App\Entity\User;
use App\Entity\Grille;
use App\Entity\EvaluationScore;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 * @ORM\Table(name="evaluation")
 */
class Evaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    private ?int $id = null;

    // 🔗 Relation: Many Evaluations → One Call
    #[ORM\ManyToOne(targetEntity: AppCall::class, inversedBy: 'evaluations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AppCall $call = null;

    // 🔗 Relation: Many Evaluations → One User (Contrôleur Qualité)
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $controleur = null;

    // 🔗 Relation: Many Evaluations → One Grille
    #[ORM\ManyToOne(targetEntity: Grille::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Grille $grille = null;

    // 🔗 Relation: One Evaluation → Many EvaluationScores
    #[ORM\OneToMany(mappedBy: 'evaluation', targetEntity: EvaluationScore::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $scores;

    // ✅ Date d’évaluation
    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull]
    private ?\DateTimeInterface $dateEvaluation = null;

    // ✅ Commentaire général
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $commentaireGlobal = null;

    // ✅ Note totale calculée
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $noteTotale = null;

    public function __construct()
    {
        $this->scores = new ArrayCollection();
        $this->dateEvaluation = new \DateTime(); // Par défaut, la date actuelle
    }

    // ----------------- Getters / Setters -----------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCall(): ?AppCall
    {
        return $this->call;
    }

    public function setCall(?AppCall $call): self
    {
        $this->call = $call;
        return $this;
    }

    public function getControleur(): ?User
    {
        return $this->controleur;
    }

    public function setControleur(?User $controleur): self
    {
        $this->controleur = $controleur;
        return $this;
    }

    public function getGrille(): ?Grille
    {
        return $this->grille;
    }

    public function setGrille(?Grille $grille): self
    {
        $this->grille = $grille;
        return $this;
    }

    /**
     * @return Collection<int, EvaluationScore>
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }

    public function addScore(EvaluationScore $score): self
    {
        if (!$this->scores->contains($score)) {
            $this->scores[] = $score;
            $score->setEvaluation($this);
        }
        return $this;
    }

    public function removeScore(EvaluationScore $score): self
    {
        if ($this->scores->removeElement($score)) {
            if ($score->getEvaluation() === $this) {
                $score->setEvaluation(null);
            }
        }
        return $this;
    }

    public function getDateEvaluation(): ?\DateTimeInterface
    {
        return $this->dateEvaluation;
    }

    public function setDateEvaluation(\DateTimeInterface $dateEvaluation): self
    {
        $this->dateEvaluation = $dateEvaluation;
        return $this;
    }

    public function getCommentaireGlobal(): ?string
    {
        return $this->commentaireGlobal;
    }

    public function setCommentaireGlobal(?string $commentaireGlobal): self
    {
        $this->commentaireGlobal = $commentaireGlobal;
        return $this;
    }

    public function getNoteTotale(): ?float
    {
        return $this->noteTotale;
    }

    public function setNoteTotale(?float $noteTotale): self
    {
        $this->noteTotale = $noteTotale;
        return $this;
    }
}
