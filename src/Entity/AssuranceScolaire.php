<?php

namespace App\Entity;

use App\Repository\AssuranceScolaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssuranceScolaireRepository::class)]
class AssuranceScolaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $addresse = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $numeroAssurance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(?string $addresse): static
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getNumeroAssurance(): ?string
    {
        return $this->numeroAssurance;
    }

    public function setNumeroAssurance(?string $numeroAssurance): static
    {
        $this->numeroAssurance = $numeroAssurance;

        return $this;
    }
}
