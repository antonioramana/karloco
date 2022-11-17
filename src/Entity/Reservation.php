<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbJour = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateRes = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $User = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Car $Car = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJour(): ?int
    {
        return $this->nbJour;
    }

    public function setNbJour(int $nbJour): self
    {
        $this->nbJour = $nbJour;

        return $this;
    }

    public function getDateRes(): ?\DateTimeInterface
    {
        return $this->dateRes;
    }

    public function setDateRes(\DateTimeInterface $dateRes): self
    {
        $this->dateRes = $dateRes;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->Car;
    }

    public function setCar(?Car $Car): self
    {
        $this->Car = $Car;

        return $this;
    }
}
