<?php

namespace App\Entity;

use App\Repository\ResposableFinancierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResposableFinancierRepository::class)]
class ResposableFinancier extends Humain
{

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $RIB = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom_employeur = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $adresse_employeur = null;

    public function getRIB(): ?string
    {
        return $this->RIB;
    }

    public function setRIB(?string $RIB): static
    {
        $this->RIB = $RIB;

        return $this;
    }

    public function getNomEmployeur(): ?string
    {
        return $this->nom_employeur;
    }

    public function setNomEmployeur(?string $nom_employeur): static
    {
        $this->nom_employeur = $nom_employeur;

        return $this;
    }

    public function getAdresseEmployeur(): ?string
    {
        return $this->adresse_employeur;
    }

    public function setAdresseEmployeur(?string $adresse_employeur): static
    {
        $this->adresse_employeur = $adresse_employeur;

        return $this;
    }
}
