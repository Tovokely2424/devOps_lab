<?php

namespace App\Entity;

use App\Repository\AppCallRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppCallRepository")
 * @ORM\Table(name="app_call")
 */
class AppCall
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    private int $id;

    // 🔗 Relation: Many Calls → One Agent (User)
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'calls')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $agent = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull]
    private ?\DateTimeInterface $dateAppel = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $fichierAudio = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 50, options: ['default' => 'pending'])]
    private string $status = 'pending';

    // 🔗 Relation: One Call → Many Evaluations
    #[ORM\OneToMany(mappedBy: 'call', targetEntity: Evaluation::class, cascade: ['persist', 'remove'])]
    private Collection $evaluations;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
    }

    // ----- Getters & Setters -----

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgent(): ?User
    {
        return $this->agent;
    }

    public function setAgent(?User $agent): self
    {
        $this->agent = $agent;
        return $this;
    }

    public function getDateAppel(): ?\DateTimeInterface
    {
        return $this->dateAppel;
    }

    public function setDateAppel(\DateTimeInterface $dateAppel): self
    {
        $this->dateAppel = $dateAppel;
        return $this;
    }

    public function getFichierAudio(): ?string
    {
        return $this->fichierAudio;
    }

    public function setFichierAudio(?string $fichierAudio): self
    {
        $this->fichierAudio = $fichierAudio;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): self
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations[] = $evaluation;
            $evaluation->setCall($this);
        }
        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            if ($evaluation->getCall() === $this) {
                $evaluation->setCall(null);
            }
        }
        return $this;
    }
}
