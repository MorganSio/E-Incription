<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use App\Entity\RepresentantLegal;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\InfoEleveRepository;

#[ORM\Entity(repositoryClass: InfoEleveRepository::class)]
class InfoEleve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_de_naissance = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $classe = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nationalite = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $departement = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom_contacte_urgence = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $numero_contacte_urgence = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dernier_rappel_antitetanique = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $observations = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $etat_matrimoniale_parents = null;

    #[ORM\Column(nullable: true)]
    private ?bool $cheque = null;

    #[ORM\Column(nullable: true)]
    private ?bool $droit_image = null;

    #[ORM\Column(nullable: true)]
    private ?bool $redoublant = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $carte_vitale = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $photo_identite = null;

    #[ORM\Column(length: 9, nullable: true)]
    private ?string $immattriculationVeic = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $bourse = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $attestationJDC = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $attestation_identite = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $attestation_reusite = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?ResposableFinancier $responsable_financier = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?CentreSecuriteSociale $secu_sociale = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?ScolariteAnterieur $anne_scolaire_un = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?ScolariteAnterieur $anne_scolaire_deux = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Langues $LVUn = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Langues $LVDeux = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?MedecinTraitant $medecin_traitant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Sexe $sexe = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?RegimeCantine $regime = null;

    #[ORM\ManyToOne(inversedBy: 'infoEleves')]
    #[ORM\JoinColumn(nullable: true)]
    private ?RepresentantLegal $responsable_un = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?RepresentantLegal $responsable_deux = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?AssuranceScolaire $assureur = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: true)]
    private User $user;

    public function __construct(user $user)
    {
        $this->user = $user;
        $user->setInfoEleve($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->date_de_naissance;
    }

    public function setDateDeNaissance(?\DateTimeInterface $date_de_naissance): static
    {
        $this->date_de_naissance = $date_de_naissance;

        return $this;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(?string $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(?string $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getNomContacteUrgence(): ?string
    {
        return $this->nom_contacte_urgence;
    }

    public function setNomContacteUrgence(?string $nom_contacte_urgence): static
    {
        $this->nom_contacte_urgence = $nom_contacte_urgence;

        return $this;
    }

    public function getNumeroContacteUrgence(): ?string
    {
        return $this->numero_contacte_urgence;
    }

    public function setNumeroContacteUrgence(?string $numero_contacte_urgence): static
    {
        $this->numero_contacte_urgence = $numero_contacte_urgence;

        return $this;
    }

    public function getDernierRappelAntitetanique(): ?\DateTimeInterface
    {
        return $this->dernier_rappel_antitetanique;
    }

    public function setDernierRappelAntitetanique(?\DateTimeInterface $dernier_rappel_antitetanique): static
    {
        $this->dernier_rappel_antitetanique = $dernier_rappel_antitetanique;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): static
    {
        $this->observations = $observations;

        return $this;
    }

    public function getEtatMatrimonialeParents(): ?string
    {
        return $this->etat_matrimoniale_parents;
    }

    public function setEtatMatrimonialeParents(?string $etat_matrimoniale_parents): static
    {
        $this->etat_matrimoniale_parents = $etat_matrimoniale_parents;

        return $this;
    }

    public function isCheque(): ?bool
    {
        return $this->cheque;
    }

    public function setCheque(?bool $cheque): static
    {
        $this->cheque = $cheque;

        return $this;
    }

    public function isDroitImage(): ?bool
    {
        return $this->droit_image;
    }

    public function setDroitImage(?bool $droit_image): static
    {
        $this->droit_image = $droit_image;

        return $this;
    }

    public function isRedoublant(): ?bool
    {
        return $this->redoublant;
    }

    public function setRedoublant(?bool $redoublant): static
    {
        $this->redoublant = $redoublant;

        return $this;
    }

    public function getCarteVitale()
    {
        return $this->carte_vitale;
    }

    public function setCarteVitale($carte_vitale): static
    {
        $this->carte_vitale = $carte_vitale;

        return $this;
    }

    public function getPhotoIdentite()
    {
        return $this->photo_identite;
    }

    public function setPhotoIdentite($photo_identite): static
    {
        $this->photo_identite = $photo_identite;

        return $this;
    }

    public function getImmattriculationVeic(): ?string
    {
        return $this->immattriculationVeic;
    }

    public function setImmattriculationVeic(?string $immattriculationVeic): static
    {
        $this->immattriculationVeic = $immattriculationVeic;

        return $this;
    }

    public function getBourse()
    {
        return $this->bourse;
    }

    public function setBourse($bourse): static
    {
        $this->bourse = $bourse;

        return $this;
    }

    public function getAttestationJDC()
    {
        return $this->attestationJDC;
    }

    public function setAttestationJDC($attestationJDC): static
    {
        $this->attestationJDC = $attestationJDC;

        return $this;
    }

    public function getAttestationIdentite()
    {
        return $this->attestation_identite;
    }

    public function setAttestationIdentite($attestation_identite): static
    {
        $this->attestation_identite = $attestation_identite;

        return $this;
    }

    public function getAttestationReusite()
    {
        return $this->attestation_reusite;
    }

    public function setAttestationReusite($attestation_reusite): static
    {
        $this->attestation_reusite = $attestation_reusite;

        return $this;
    }

    public function getResponsableFinancier(): ?ResposableFinancier
    {
        return $this->responsable_financier;
    }

    public function setResponsableFinancier(?ResposableFinancier $responsable_financier): static
    {
        $this->responsable_financier = $responsable_financier;

        return $this;
    }

    public function getSecuSociale(): ?CentreSecuriteSociale
    {
        return $this->secu_sociale;
    }

    public function setSecuSociale(?CentreSecuriteSociale $secu_sociale): static
    {
        $this->secu_sociale = $secu_sociale;

        return $this;
    }

    public function getAnneScolaireUn(): ?ScolariteAnterieur
    {
        return $this->anne_scolaire_un;
    }

    public function setAnneScolaireUn(?ScolariteAnterieur $anne_scolaire_un): static
    {
        $this->anne_scolaire_un = $anne_scolaire_un;

        return $this;
    }

    public function getAnneScolaireDeux(): ?ScolariteAnterieur
    {
        return $this->anne_scolaire_deux;
    }

    public function setAnneScolaireDeux(?ScolariteAnterieur $anne_scolaire_deux): static
    {
        $this->anne_scolaire_deux = $anne_scolaire_deux;

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

    public function getLVDeux(): ?Langues
    {
        return $this->LVDeux;
    }

    public function setLVDeux(?Langues $LVDeux): static
    {
        $this->LVDeux = $LVDeux;

        return $this;
    }

    public function getMedecinTraitant(): ?MedecinTraitant
    {
        return $this->medecin_traitant;
    }

    public function setMedecinTraitant(?MedecinTraitant $medecin_traitant): static
    {
        $this->medecin_traitant = $medecin_traitant;

        return $this;
    }

    public function getsexe(): ?Sexe
    {
        return $this->sexe;
    }

    public function setsexe(?Sexe $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getRegime(): ?RegimeCantine
    {
        return $this->regime;
    }

    public function setRegime(?RegimeCantine $regime): static
    {
        $this->regime = $regime;

        return $this;
    }

    public function getResponsableUn(): ?RepresentantLegal
    {
        return $this->responsable_un;
    }

    public function setResponsableUn(?RepresentantLegal $responsable_un): static
    {
        $this->responsable_un = $responsable_un;

        return $this;
    }

    public function getResponsableDeux(): ?RepresentantLegal
    {
        return $this->responsable_deux;
    }

    public function setResponsableDeux(?RepresentantLegal $responsable_deux): static
    {
        $this->responsable_deux = $responsable_deux;

        return $this;
    }

    public function getAssureur(): ?AssuranceScolaire
    {
        return $this->assureur;
    }

    public function setAssureur(?AssuranceScolaire $assureur): static
    {
        $this->assureur = $assureur;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function switchResponsable()
    {
        $repLegaltemp = $this->getResponsableDeux();
        $this->setResponsableDeux($this->getResponsableUn());
        $this->setResponsableUn($repLegaltemp);
    }

}
