<?php

namespace App\Entity;

use App\Repository\AccedeRepresentantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccedeRepresentantRepository::class)]
class AccedeRepresentant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'accedeRepresentant')]
    private Collection $utilisateur;

    /**
     * @var Collection<int, RepresentantLegal>
     */
    #[ORM\OneToMany(targetEntity: RepresentantLegal::class, mappedBy: 'accedeRepresentant')]
    private Collection $representant;

    public function __construct()
    {
        $this->utilisateur = new ArrayCollection();
        $this->representant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $utilisateur->setAccedeRepresentant($this);
        }

        return $this;
    }

    public function removeUtilisateur(User $utilisateur): static
    {
        if ($this->utilisateur->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getAccedeRepresentant() === $this) {
                $utilisateur->setAccedeRepresentant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RepresentantLegal>
     */
    public function getRepresentant(): Collection
    {
        return $this->representant;
    }

    public function addRepresentant(RepresentantLegal $representant): static
    {
        if (!$this->representant->contains($representant)) {
            $this->representant->add($representant);
            $representant->setAccedeRepresentant($this);
        }

        return $this;
    }

    public function removeRepresentant(RepresentantLegal $representant): static
    {
        if ($this->representant->removeElement($representant)) {
            // set the owning side to null (unless already changed)
            if ($representant->getAccedeRepresentant() === $this) {
                $representant->setAccedeRepresentant(null);
            }
        }

        return $this;
    }
}
