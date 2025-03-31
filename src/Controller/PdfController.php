<?php

namespace App\Controller;

use App\Service\DocxGeneratorService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PdfController extends AbstractController
{
    // #[Route('/admin/generer-pdf/{id}', name: 'generer_pdf')]
    // public function generatePdf(int $id, PdfFillerService $pdfFillerService): Response
    // {
    //     return $pdfFillerService->generatePdf($id);
    // }

    private DocxGeneratorService $docxGeneratorService;

    public function __construct(DocxGeneratorService $docxGeneratorService)
    {

        $this->docxGeneratorService = $docxGeneratorService;
    }


    #[Route('/admin/generer-docx/{id}', name: 'generer_docx')]
    public function generateDocx(int $id): Response
    {
        try {
            // Appeler la méthode du service pour générer le fichier DOCX
            return $this->docxGeneratorService->generateDocx($id);
        } catch (\Exception $e) {
            // Gestion des erreurs
            return new Response("Erreur lors de la génération du fichier DOCX : " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}