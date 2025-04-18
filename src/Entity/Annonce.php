<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *      fields = { "tittle" }, 
 *      message = "Une autre annonce possède déjà ce titre, veuillez le modifier"
 * )
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *                  min = 20, 
     *                  max = 100, 
     *                  minMessage = "Le titre doit faire plus de 20 cacactère", 
     *                  maxMessage = "Le titre doit faire moins de 100 cacactère"
     *               )
     */
    private $tittle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *                  min = 100, 
     *                  max = 255, 
     *                  minMessage = "Le titre doit faire plus de 20 cacactère", 
     *                  maxMessage = "Le titre doit faire moins de 100 cacactère"
     *               )
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *                  min = 100, 
     *                  minMessage = "Le titre doit faire plus de 20 cacactère"
     *               )
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $converImage;

    /**
     * @ORM\Column(type="integer")
     */
    private $rooms;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="annonce", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * Premet d'initialiser le slug en fontion de 2 evenement
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return void
     */
    public function intializeSlug(){
        if (empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->tittle);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTittle(): ?string
    {
        return $this->tittle;
    }

    public function setTittle(string $tittle): self
    {
        $this->tittle = $tittle;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getConverImage(): ?string
    {
        return $this->converImage;
    }

    public function setConverImage(string $converImage): self
    {
        $this->converImage = $converImage;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAnnonce($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAnnonce() === $this) {
                $image->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
