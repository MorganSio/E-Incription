<?php

namespace App\Entity;

use App\Repository\AccedeEleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccedeEleveRepository::class)]
class AccedeEleve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, InfoEleve>
     */
    #[ORM\OneToMany(targetEntity: InfoEleve::class, mappedBy: 'accedeEleve')]
    private Collection $eleve;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'accedeEleve')]
    private Collection $utilisateur;

    public function __construct()
    {
        $this->eleve = new ArrayCollection();
        $this->utilisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, InfoEleve>
     */
    public function getEleve(): Collection
    {
        return $this->eleve;
    }

    public function addEleve(InfoEleve $eleve): static
    {
        if (!$this->eleve->contains($eleve)) {
            $this->eleve->add($eleve);
            $eleve->setAccedeEleve($this);
        }

        return $this;
    }

    public function removeEleve(InfoEleve $eleve): static
    {
        if ($this->eleve->removeElement($eleve)) {
            // set the owning side to null (unless already changed)
            if ($eleve->getAccedeEleve() === $this) {
                $eleve->setAccedeEleve(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUtilisateur(): Collection
    {
        return $this->utilisateur;
    }

    public function addUtilisateur(User $utilisateur): static
    {
        if (!$this->utilisateur->contains($utilisateur)) {
            $this->utilisateur->add($utilisateur);
            $utilisateur->setAccedeEleve($this);
        }

        return $this;
    }

    public function removeUtilisateur(User $utilisateur): static
    {
        if ($this->utilisateur->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getAccedeEleve() === $this) {
                $utilisateur->setAccedeEleve(null);
            }
        }

        return $this;
    }
}
