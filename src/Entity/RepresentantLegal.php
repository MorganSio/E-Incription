<?php

namespace App\Entity;

use App\Repository\RepresentantLegalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepresentantLegalRepository::class)]
class RepresentantLegal extends Humain
{
    #[ORM\Column(length: 15, nullable: true)]
    private ?string $telephone_fixe = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $telephone_pro = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $poste = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom_employeur = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $adresse_employeur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $RIB = null;

    #[ORM\OneToOne]
    private InfoEleve $infoEleve;


    public function getTelephoneFixe(): ?string
    {
        return $this->telephone_fixe;
    }

    public function setTelephoneFixe(?string $telephone_fixe): static
    {
        $this->telephone_fixe = $telephone_fixe;

        return $this;
    }

    public function getTelephonePro(): ?string
    {
        return $this->telephone_pro;
    }

    public function setTelephonePro(?string $telephone_pro): static
    {
        $this->telephone_pro = $telephone_pro;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(?string $poste): static
    {
        $this->poste = $poste;

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

    public function getRIB(): ?string
    {
        return $this->RIB;
    }

    public function setRIB(?string $RIB): static
    {
        $this->RIB = $RIB;

        return $this;
    }

    public function getInfoEleves(): InfoEleve
    {
        return $this->infoEleve;
    }

    public function removeInfoElefe(InfoEleve $infoEleve): static
    {
        $this->infoEleve = $infoEleve;
        return $this;

    }

}
