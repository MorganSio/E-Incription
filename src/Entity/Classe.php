<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $anee = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, InfoEleve>
     */
    #[ORM\OneToMany(targetEntity: InfoEleve::class, mappedBy: 'classe')]
    private Collection $infoEleves;

    public function __construct()
    {
        $this->infoEleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnee(): ?int
    {
        return $this->anee;
    }

    public function setAnee(int $anee): static
    {
        $this->anee = $anee;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, InfoEleve>
     */
    public function getInfoEleves(): Collection
    {
        return $this->infoEleves;
    }

    public function addInfoElefe(InfoEleve $infoElefe): static
    {
        if (!$this->infoEleves->contains($infoElefe)) {
            $this->infoEleves->add($infoElefe);
            $infoElefe->setClasse($this);
        }

        return $this;
    }

    public function removeInfoElefe(InfoEleve $infoElefe): static
    {
        if ($this->infoEleves->removeElement($infoElefe)) {
            // set the owning side to null (unless already changed)
            if ($infoElefe->getClasse() === $this) {
                $infoElefe->setClasse(null);
            }
        }

        return $this;
    }
}
