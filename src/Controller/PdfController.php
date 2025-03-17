<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Humain;
use App\Entity\RepresentantLegal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use setasign\Fpdi\Fpdi;

class PdfController extends AbstractController
{
    #[Route('/admin/generer-pdf/{id}', name: 'generer_pdf')]
    public function genererPdf(int $id, EntityManagerInterface $entityManager): Response
    {
        // 🔹 Récupération de l'utilisateur
        $user = $entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // 🔹 Récupération des données de l'étudiant et du représentant légal
        $etudiant = $entityManager->getRepository(Humain::class)->findOneBy(['user' => $user]);
        $representant = $entityManager->getRepository(RepresentantLegal::class)->findOneBy(['etudiant' => $etudiant]);

        if (!$etudiant || !$representant) {
            throw $this->createNotFoundException('Données manquantes pour cet utilisateur.');
        }

        // 🔹 Charger le modèle PDF existant
        $pdfPath = $this->getParameter('kernel.project_dir') . '/public/pdf/dossier_bts.pdf';
        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile($pdfPath);
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 0, 0, 210);

        // 🔹 Configuration de la police
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);

        // 🔹 Ajout des informations dans le PDF
        $pdf->SetXY(50, 50);
        $pdf->Write(10, "Nom : " . $user->getNom());

        $pdf->SetXY(50, 60);
        $pdf->Write(10, "Email : " . $user->getEmail());

        $pdf->SetXY(50, 70);
        $pdf->Write(10, "N° Sécurité Sociale : " . $etudiant->getNumSecuriteSociale());

        $pdf->SetXY(50, 80);
        $pdf->Write(10, "Nationalité : " . $etudiant->getNationalite());

        $pdf->SetXY(50, 90);
        $pdf->Write(10, "Téléphone Mobile : " . $etudiant->getTelephoneMobile());

        $pdf->SetXY(50, 100);
        $pdf->Write(10, "Date de naissance : " . $etudiant->getDateNaissance()->format('d/m/Y'));

        $pdf->SetXY(50, 140);
        $pdf->Write(10, "Nom Resp. : " . $representant->getNom());

        $pdf->SetXY(50, 150);
        $pdf->Write(10, "Prénom Resp. : " . $representant->getPrenom());

        $pdf->SetXY(50, 160);
        $pdf->Write(10, "Adresse : " . $representant->getAdresse());

        $pdf->SetXY(50, 180);
        $pdf->Write(10, "Téléphone Resp. : " . $representant->getTelephoneMobile());

        // 🔹 Sauvegarde et téléchargement du PDF
        $pdfFilename = 'dossier_etudiant_' . $user->getId() . '.pdf';
        $pdfOutputPath = $this->getParameter('kernel.project_dir') . '/public/generated_pdfs/' . $pdfFilename;
        $pdf->Output($pdfOutputPath, 'F');

        return $this->file($pdfOutputPath, $pdfFilename, Response::HTTP_OK);
    }
}
