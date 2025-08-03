<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\RubriqueRepository;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RubriqueRepository")
 */
class Rubrique
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $titre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Grille", inversedBy="rubriques")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Grille $grille = null;

    /*
    *@ORM\OneToMany(targetEntity="App\Entity\Critere", mappedBy="rubrique")
    */
    private Collection $criteres;

    public function __construct()
    {
        $this->criteres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
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
    public function getCriteres(): Collection
    {
        return $this->criteres;
    }

    public function addCritere(Critere $critere): self
    {
        if (!$this->criteres->contains($critere)) {
            $this->criteres[] = $critere;
            $critere->setRubrique($this);
        }
        return $this;
    }

    public function removeCritere(Critere $critere): self
    {
        if ($this->criteres->removeElement($critere)) {
            if ($critere->getRubrique() === $this) {
                $critere->setRubrique(null);
            }
        }
        return $this;
    }
}
