<?php

namespace App\Controller;

use App\Service\CloudService;
use App\Service\DocxIntendanceGeneratorService;
use App\Service\DocxUrgenceGeneratorService;
use App\Service\DocxMdlGeneratorService;
use App\Service\DocxdossierGeneratorService;
use App\Service\LocalDocxToPdfConverter;
use CloudConvert\CloudConvert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PdfController extends AbstractController
{
    private DocxIntendanceGeneratorService $docxIntendanceGeneratorService;
    private DocxUrgenceGeneratorService $docxUrgenceGeneratorService;
    private DocxMdlGeneratorService $docxMdlGeneratorService;
    private DocxdossierGeneratorService $docxdossierGeneratorService;
    private CloudService $pdfConverter;

    public function __construct(
        DocxIntendanceGeneratorService $docxIntendanceGeneratorService,
        DocxUrgenceGeneratorService $docxUrgenceGeneratorService,
        DocxMdlGeneratorService $docxMdlGeneratorService,
        DocxdossierGeneratorService $docxdossierGeneratorService,
        CloudService $pdfConverter
    ) {
        $this->docxIntendanceGeneratorService = $docxIntendanceGeneratorService;
        $this->docxUrgenceGeneratorService = $docxUrgenceGeneratorService;
        $this->docxMdlGeneratorService = $docxMdlGeneratorService;
        $this->docxdossierGeneratorService = $docxdossierGeneratorService;
        $this->pdfConverter = $pdfConverter;
    }

    #[Route('/admin/generer-docx_intendance/{id}', name: 'generer_docx_intendance')]
    public function generateDocxIntendance(int $id): Response
    {
        try {
            $docxPath = $this->docxIntendanceGeneratorService->generateDocx($id, returnPath: true);
            $pdfPath = $this->pdfConverter->convert($docxPath, dirname($docxPath));
            return $this->file($pdfPath);
        } catch (\Exception $e) {
            return new Response("Erreur génération fichier Intendance : " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/admin/generer-docx_urgence/{id}', name: 'generer_docx_urgence')]
    public function generateDocxUrgence(int $id): Response
    {
        try {
            $docxPath = $this->docxUrgenceGeneratorService->generateDocx($id, returnPath: true);
            $pdfPath = $this->pdfConverter->convert($docxPath, dirname($docxPath));
            return $this->file($pdfPath);
        } catch (\Exception $e) {
            return new Response("Erreur génération fichier Urgence : " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/admin/generer-docx_mdl/{id}', name: 'generer_docx_mdl')]
    public function generateDocxMdl(int $id): Response
    {
        try {
            $docxPath = $this->docxMdlGeneratorService->generateDocx($id, returnPath: true);
            $pdfPath = $this->pdfConverter->convert($docxPath, dirname($docxPath));
            return $this->file($pdfPath);
        } catch (\Exception $e) {
            return new Response("Erreur génération fichier MDL : " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/admin/generer-docx_dossier/{id}', name: 'generer_docx_dossier')]
    public function generateDocx(int $id): Response
    {
        try {
            $docxPath = $this->docxdossierGeneratorService->generateDocx($id, returnPath: true);
            $pdfPath = $this->pdfConverter->convert($docxPath, dirname($docxPath));
            return $this->file($pdfPath);
        } catch (\Exception $e) {
            return new Response("Erreur génération fichier Dossier BTS : " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}