<?php

namespace App\Controller;

use App\Service\DocxIntendanceGeneratorService;
use App\Service\DocxUrgenceGeneratorService;
use App\Service\DocxMdlGeneratorService;
use App\Service\DocxdossierGeneratorService;
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

    private DocxIntendanceGeneratorService $docxIntendanceGeneratorService;
    private DocxUrgenceGeneratorService $docxUrgenceGeneratorService;
    private DocxMdlGeneratorService $docxMdlGeneratorService;
    private DocxdossierGeneratorService $docxdossierGeneratorService;

    public function __construct(DocxIntendanceGeneratorService $docxIntendanceGeneratorService, DocxUrgenceGeneratorService $docxUrgenceGeneratorService, DocxMdlGeneratorService $docxMdlGeneratorService, DocxdossierGeneratorService $docxdossierGeneratorService) 
    {

        $this->docxIntendanceGeneratorService = $docxIntendanceGeneratorService;
        $this->docxUrgenceGeneratorService = $docxUrgenceGeneratorService;
        $this->docxMdlGeneratorService = $docxMdlGeneratorService;
        $this->docxdossierGeneratorService = $docxdossierGeneratorService;
    }


    #[Route('/admin/generer-docx_intendance/{id}', name: 'generer_docx_intendance')]
    public function generateDocxIntendance(int $id): Response
    {
        try {
            // Appeler la méthode du service pour générer le fichier DOCX
            return $this->docxIntendanceGeneratorService->generateDocx($id);
        } catch (\Exception $e) {
            // Gestion des erreurs
            return new Response("Erreur lors de la génération du fichier DOCX : " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/admin/generer-docx_urgence/{id}', name: 'generer_docx_urgence')]
    public function generateDocxUrgence(int $id): Response
    {
        try {
            // Appeler la méthode du service pour générer le fichier DOCX
            return $this->docxUrgenceGeneratorService->generateDocx($id);
        } catch (\Exception $e) {
            // Gestion des erreurs
            return new Response("Erreur lors de la génération du fichier DOCX : " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/admin/generer-docx_mdl/{id}', name: 'generer_docx_mdl')]
    public function generateDocxMdl(int $id): Response
    {
        try {
            // Appeler la méthode du service pour générer le fichier DOCX
            return $this->docxMdlGeneratorService->generateDocx($id);
        } catch (\Exception $e) {
            // Gestion des erreurs
            return new Response("Erreur lors de la génération du fichier DOCX : " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/admin/generer-docx_dossier/{id}', name: 'generer_docx_dossier')]
    public function generateDocx(int $id): Response
    {
        try {
            // Appeler la méthode du service pour générer le fichier DOCX
            return $this->docxdossierGeneratorService->generateDocx($id);
        } catch (\Exception $e) {
            // Gestion des erreurs
            return new Response("Erreur lors de la génération du fichier DOCX : " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}