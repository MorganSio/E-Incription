<?php

namespace App\Entity;

use App\Repository\ScolariteAnterieurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScolariteAnterieurRepository::class)]
class ScolariteAnterieur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 9, nullable: true)]
    private ?string $anne_scolaire = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $classe = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $option = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $etablissement = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Langues $LVDeux = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Langues $LVUn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnneScolaire(): ?string
    {
        return $this->anne_scolaire;
    }

    public function setAnneScolaire(string $anne_scolaire): static
    {
        $this->anne_scolaire = $anne_scolaire;

        return $this;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(?string $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getOption(): ?string
    {
        return $this->option;
    }

    public function setOption(?string $option): static
    {
        $this->option = $option;

        return $this;
    }

    public function getEtablissement(): ?string
    {
        return $this->etablissement;
    }

    public function setEtablissement(?string $etablissement): static
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    public function getLVDeux(): ?Langues
    {
        return $this->LVDeux;
    }

    public function setLVDeux(?Langues $LVDeux): static
    {
        $this->LVDeux = $LVDeux;

        return $this;
    }

    public function getLVUn(): ?Langues
    {
        return $this->LVUn;
    }

    public function setLVUn(?Langues $LVUn): static
    {
        $this->LVUn = $LVUn;

        return $this;
    }
}
