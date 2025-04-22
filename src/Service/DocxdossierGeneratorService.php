<?php

namespace App\Service;

use App\Entity\InfoEleve;
use App\Entity\Humain;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DocxdossierGeneratorService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generateDocx(int $etudiantId): BinaryFileResponse
    {
        $etudiant = $this->entityManager->getRepository(InfoEleve::class)->find($etudiantId);

        if (!$etudiant) {
            throw new NotFoundHttpException("Étudiant non trouvé.");
        }

        $nom = $etudiant->getUser()?->getNom() ?? 'etudiant';
        $templatePath = __DIR__ . '/../../public/templates/dossier bts.docx';
        $outputDocxPath = __DIR__ . '/../../public/generated/dossier_bts_' . $nom . '.docx';

        $templateProcessor = new TemplateProcessor($templatePath);
        $this->fillTemplate($templateProcessor, $etudiant);
        $templateProcessor->saveAs($outputDocxPath);

        return $this->createDocxDownloadResponse($outputDocxPath);
    }

    private function fillTemplate(TemplateProcessor $templateProcessor, InfoEleve $etudiant): void
    {
        $user = $etudiant->getUser();

        // === ÉTUDIANT ===
        $templateProcessor->setValue('etudiant.nom', $user?->getNom() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.prenom', $user?->getPrenom() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.num_secu', ''); // À adapter si tu l’as
        $templateProcessor->setValue('etudiant.date_nais', $etudiant->getDateDeNaissance()?->format('d/m/Y') ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.sexe', $etudiant->getSexe()?->getLabel() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.nationalite', $etudiant->getNationalite() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.dep_nais', $etudiant->getDepartement() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.com_nais', $etudiant?->getCommuneNaissance() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.tel', $user instanceof Humain ? $user->getTelephonePerso() ?? 'Non renseigné' : 'Non renseigné');
        $templateProcessor->setValue('etudiant.courriel', $user instanceof Humain ? $user->getCourriel() ?? 'Non renseigné' : 'Non renseigné');
        $templateProcessor->setValue('etudiant.immatri', $etudiant->getImmattriculationVeic() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.redoublement', $etudiant->isRedoublant() ? 'Oui' : 'Non');

        $templateProcessor->setValue('etudiant.classe', $etudiant->getClasse() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.specialite', $etudiant->getClasse()?->getLabel() ?? 'Non renseigné'); // À adapter
        $templateProcessor->setValue('etudiant.lv1', $etudiant->getLVUn()?->getLabel() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.lv2', $etudiant->getLVDeux()?->getLabel() ?? 'Non renseigné');

        // === SCOLARITÉS ANTÉRIEURES ===
        $templateProcessor->setValue('etudiant.annee_sco_1', $etudiant->getAnneScolaireUn()?->getAnneScolaire() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.annee_sco_2', $etudiant->getAnneScolaireDeux()?->getAnneScolaire() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.classe_1', $etudiant->getAnneScolaireUn()?->getClasse() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.classe_2', $etudiant->getAnneScolaireDeux()?->getClasse() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.lv1_1', $etudiant->getAnneScolaireUn()?->getLVUn()?->getLabel() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.lv1_2', $etudiant->getAnneScolaireDeux()?->getLVUn()?->getLabel() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.lv2_1', $etudiant->getAnneScolaireUn()?->getLVDeux()?->getLabel() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.lv2_2', $etudiant->getAnneScolaireDeux()?->getLVDeux()?->getLabel() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.option_1', $etudiant->getAnneScolaireUn()?->getOption() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.option_2', $etudiant->getAnneScolaireDeux()?->getOption() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.etab_1', $etudiant->getAnneScolaireUn()?->getEtablissement() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.etab_2', $etudiant->getAnneScolaireDeux()?->getEtablissement() ?? 'Non renseigné');
        $templateProcessor->setValue('etudiant.dernier_diplome', $etudiant->getDernierDiplome() ?? 'Non renseigné');

        $isMajeur = $etudiant->getDateDeNaissance()?->diff(new \DateTime())->y >= 18;
        $hasNoResponsables = !$etudiant->getResponsableUn() && !$etudiant->getResponsableDeux();
        $estMajeurIndependant = $isMajeur && $hasNoResponsables;

        if ($estMajeurIndependant) {
            $user = $etudiant->getUser();

            if ($user instanceof \App\Entity\Humain) {
                $templateProcessor->setValue('majeur.adresse', $user->getAdresse() ?? 'Non renseigné');
                $templateProcessor->setValue('majeur.commune', $user->getCommune() ?? 'Non renseigné');
                $templateProcessor->setValue('majeur.tel_perso', $user->getTelephonePerso() ?? 'Non renseigné');
                $templateProcessor->setValue('majeur.tel_dom', $user->getTelephonePerso() ?? 'Non renseigné');
                $templateProcessor->setValue('majeur.courriel', $user->getCourriel() ?? 'Non renseigné');
            } else {
                $templateProcessor->setValue('majeur.adresse', 'Non renseigné');
                $templateProcessor->setValue('majeur.commune', 'Non renseigné');
                $templateProcessor->setValue('majeur.tel_perso', 'Non renseigné');
                $templateProcessor->setValue('majeur.tel_dom', 'Non renseigné');
                $templateProcessor->setValue('majeur.courriel', 'Non renseigné');
            }
        } else {
            // Si pas majeur indépendant => on vide les champs
            foreach (['adresse', 'commune', 'tel_perso', 'courriel', 'tel_dom'] as $champ) {
                $templateProcessor->setValue("majeur.$champ", '');
            }
        }

        // === RESPONSABLES LÉGAUX ===
        $this->setResponsableValues($templateProcessor, 'rep_legal1', $etudiant->getResponsableUn() ?? $etudiant);
        $this->setResponsableValues($templateProcessor, 'rep_legal2', $etudiant->getResponsableDeux() ?? null);
    }

    private function setResponsableValues(TemplateProcessor $templateProcessor, string $prefix, $source): void
    {
        if (!$source) {
            foreach ([
                'nom', 'prenom', 'adresse', 'commune', 'courriel',
                'tel_dom', 'tel_travail', 'tel_perso', 'profession'
            ] as $field) {
                $templateProcessor->setValue("{$prefix}.{$field}", 'Non renseigné');
            }
            return;
        }

        $templateProcessor->setValue("{$prefix}.nom", $source->getNom() ?? 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.prenom", $source->getPrenom() ?? 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.adresse", $source->getAdresse() ?? 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.commune", $source->getCommune() ?? 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.courriel", $source->getCourriel() ?? 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.tel_dom", $source->getTelephoneFixe() ?? 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.tel_travail", $source->getTelephonePro() ?? 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.tel_perso", $source->getTelephonePerso() ?? 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.profession", $source->getPoste() ?? 'Non renseigné');
    }

    private function createDocxDownloadResponse(string $filePath): BinaryFileResponse
    {
        return new BinaryFileResponse($filePath, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
        ]);
    }
}