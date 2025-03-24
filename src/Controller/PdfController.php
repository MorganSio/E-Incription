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
        $eleve = $entityManager->getRepository(InfoEleve::class)->find($id);
        if (!$eleve) {
            throw $this->createNotFoundException('Étudiant non trouvé.');
        }

        $pdfPath = $this->getParameter('kernel.project_dir') . '/public/pdf/template.pdf'; // Remplacez par votre fichier PDF existant
        $outputPath = $this->getParameter('kernel.project_dir') . '/public/pdf/dossiers/dossier_' . $eleve->getId() . '.pdf';

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
    }
}
