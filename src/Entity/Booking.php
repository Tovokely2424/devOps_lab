<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony/Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 * @ORM\HasLifeCycleCallbacks
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $booker;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $bookingAnnonce;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual("today", message="La date de début doit être supérieure ou égale à aujourd'hui.")
     * @Assert\LessThan(propertyPath="endDate", message="La date de début doit être inférieure à la date de fin.")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan(propertyPath="startDate", message="La date de fin doit être supérieure à la date de début.")
     * @Assert\LessThanOrEqual("next year", message="La date selectionnés doit être cette année.")
     */
    private $endDate;
    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * Permet de générer la date de création, Calculer le montant avant même de persister l'entité
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        if(empty($this->createdAt)) {
            $this->createdAt = new \DateTimeImmutable();
        }
        if(empty($this->amount)){
            $this->amount = $this->bookingAnnonce->getPrice() * $this->getDuration();
        }
    }

    public function getDuration(): int
    {
        return $this->startDate->diff($this->endDate)->days;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooker(): ?User
    {
        return $this->booker;
    }

    public function setBooker(?User $booker): self
    {
        $this->booker = $booker;

        return $this;
    }

    public function getBookingAnnonce(): ?Annonce
    {
        return $this->bookingAnnonce;
    }

    public function setBookingAnnonce(?Annonce $bookingAnnonce): self
    {
        $this->bookingAnnonce = $bookingAnnonce;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
