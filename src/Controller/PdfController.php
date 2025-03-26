<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Humain;
use App\Entity\RepresentantLegal;
use App\Entity\InfoEleve;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use setasign\Fpdi\Fpdi;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PdfController extends AbstractController
{
    #[Route('/admin/generer-pdf/{id}', name: 'generer_pdf')]
    public function genererPdf(int $id, EntityManagerInterface $entityManager): Response
    {
<<<<<<< HEAD
        $eleve = $entityManager->getRepository(InfoEleve::class)->find($id);
        if (!$eleve) {
            throw $this->createNotFoundException('Étudiant non trouvé.');
        }

        $pdfPath = $this->getParameter('kernel.project_dir') . '/public/pdf/template.pdf'; // Remplacez par votre fichier PDF existant
        $outputPath = $this->getParameter('kernel.project_dir') . '/public/pdf/dossiers/dossier_' . $eleve->getId() . '.pdf';

=======
>>>>>>> 2f251d8c9d9d252f7fbb3ece642eec1ad4a23fd9
        $user = $entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $etudiant = $entityManager->getRepository(Humain::class)->findOneBy(['user' => $user]);
        $representant = $entityManager->getRepository(RepresentantLegal::class)->findOneBy(['etudiant' => $etudiant]);

        if (!$etudiant || !$representant) {
            throw $this->createNotFoundException('Données manquantes pour cet utilisateur.');
        }

        $pdfPath = $this->getParameter('kernel.project_dir') . '/public/pdf/dossier_bts.pdf';

        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile($pdfPath);
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 10, 10, 190);

        $pdf->SetFont('Arial', '', 12);

        $pdf->SetXY(50, 50);
        $pdf->Write(10, utf8_decode($eleve->getUser()->getNom()));

        $pdf->SetXY(50, 60);
        $pdf->Write(10, utf8_decode($eleve->getUser()->getPrenom()));

        $pdf->SetXY(50, 70);
        $pdf->Write(10, $eleve->getDateDeNaissance() ? $eleve->getDateDeNaissance()->format('d/m/Y') : "Non renseigné");

        $pdf->SetXY(50, 80);
        $pdf->Write(10, utf8_decode($eleve->getClasse()));

        if ($eleve->getResponsableUn()) {
            $pdf->SetXY(50, 90);
            $pdf->Write(10, utf8_decode($eleve->getResponsableUn()->getNom()));

            $pdf->SetXY(50, 100);
            $pdf->Write(10, utf8_decode($eleve->getResponsableUn()->getPrenom()));

            $pdf->SetXY(50, 110);
            $pdf->Write(10, utf8_decode($eleve->getResponsableUn()->getAdresse()));
        }

        $pdf->SetXY(50, 130);
        switch ($eleve->getRegime()->getNom()) {
            case 'forfait5':
                $pdf->Write(10, "✅ Demi-pensionnaire 5 jours");
                break;
            case 'forfait4':
                $pdf->Write(10, "✅ Demi-pensionnaire 4 jours");
                break;
            case 'tickets':
                $pdf->Write(10, "✅ Tickets");
                break;
            default:
                $pdf->Write(10, "✅ Externe");
                break;
        }

        $pdf->Output($outputPath, 'F');

        return new BinaryFileResponse($outputPath);
        $pdf->useTemplate($tplIdx, 0, 0, 210);

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);

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

        $pdfFilename = 'dossier_etudiant_' . $user->getId() . '.pdf';
        $pdfOutputPath = $this->getParameter('kernel.project_dir') . '/public/generated_pdfs/' . $pdfFilename;
        $pdf->Output($pdfOutputPath, 'F');

        return $this->file($pdfOutputPath, $pdfFilename, Response::HTTP_OK);
    }
}
