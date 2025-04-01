<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\InfoEleve;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocxUrgenceGeneratorService
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

        $templatePath = __DIR__ . "/../../public/templates/Fiche d'urgence.docx";
        $outputDocxPath = __DIR__ . "/../../public/generated/Fiche_d_urgence_".$etudiant->getUser()->getNom().'.docx';

        // Charger et remplir le modèle Word
        $templateProcessor = new TemplateProcessor($templatePath);
        $this->fillTemplate($templateProcessor, $etudiant);
        $templateProcessor->saveAs($outputDocxPath);

        // Retourner une réponse qui permet le téléchargement du fichier DOCX
        return $this->createDocxDownloadResponse($outputDocxPath);
    }

    private function fillTemplate(TemplateProcessor $templateProcessor, InfoEleve $etudiant)
    {
        // Remplir les informations de l'étudiant
        $templateProcessor->setValue('etudiant.nom', $etudiant->getUser()->getNom());
        $templateProcessor->setValue('etudiant.prenom', $etudiant->getUser()->getPrenom());
        $templateProcessor->setValue('etudiant.date_naissance', $etudiant->getDateDeNaissance() ? $etudiant->getDateDeNaissance()->format('d/m/Y') : 'Non renseigné');
        $templateProcessor->setValue('etudiant.classe', $etudiant->getClasse() ?? 'Non renseigné');

        // Remplir les informations du responsable légal
        $responsableLegal = $etudiant->getResponsableUn() ?? $etudiant;
        $this->setResponsableValues($templateProcessor, 'representant', $responsableLegal);

        // Remplir les informations du responsable financier
        if ($etudiant->getResponsableUn()) {
            $this->setResponsableValues($templateProcessor, 'responsable_financier', $etudiant->getResponsableUn());
        }
    }

    private function setResponsableValues(TemplateProcessor $templateProcessor, string $prefix, $responsable)
    {
        if (!$responsable || !method_exists($responsable, 'getUser')) {
            return;
        }

        $templateProcessor->setValue("{$prefix}.nom", $responsable->getUser()->getNom());
        $templateProcessor->setValue("{$prefix}.prenom", $responsable->getUser()->getPrenom());
        $templateProcessor->setValue("{$prefix}.adresse", method_exists($responsable, 'getAdresse') ? $responsable->getAdresse() : 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.code_postal", method_exists($responsable, 'getCodePostal') ? $responsable->getCodePostal() : 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.ville", method_exists($responsable, 'getVille') ? $responsable->getVille() : 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.telephone", method_exists($responsable, 'getTelephone') ? $responsable->getTelephone() : 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.email", method_exists($responsable, 'getEmail') ? $responsable->getEmail() : 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.nom_employeur", method_exists($responsable, 'getNomEmployeur') ? $responsable->getNomEmployeur() : 'Non renseigné');
        $templateProcessor->setValue("{$prefix}.adresse_employeur", method_exists($responsable, 'getAdresseEmployeur') ? $responsable->getAdresseEmployeur() : 'Non renseigné');
    }

    private function createDocxDownloadResponse(string $filePath): BinaryFileResponse
    {
        // Créer une réponse HTTP pour le téléchargement du fichier DOCX
        return new BinaryFileResponse($filePath, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
        ]);
    }
}
