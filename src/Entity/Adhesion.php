<?php

namespace App\Entity;

use App\Repository\AdhesionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdhesionRepository::class)]
class Adhesion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $accepted;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $paymentMethod;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $imageRights;

    // Getters and setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccepted(bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getImageRights(): ?bool
    {
        return $this->imageRights;
    }

    public function setImageRights(?bool $imageRights): self
    {
        $this->imageRights = $imageRights;

        return $this;
    }
}
