<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FichierUploadController extends AbstractController
{
    #[Route('/fichier-upload', name: 'fichier-upload')]
    public function index(): Response
    {
        return $this->render('fichier_upload/index.html.twig', [
            'controller_name' => 'FichierUploadController',
        ]);
    }

    public function upload(Request $request): Response
    {
        $signatureBase64 = $request->request->get('signature');

        if (!$signatureBase64) {
            $this->addFlash('error', 'Signature électronique requise.');
            return $this->redirectToRoute('fichier-upload');
        }

        // Décoder la signature
        $signatureData = explode(',', $signatureBase64);
        if (count($signatureData) !== 2) {
            $this->addFlash('error', 'Signature invalide.');
            return $this->redirectToRoute('fichier-upload');
        }

        $signatureDecoded = base64_decode($signatureData[1]);
        if (!$signatureDecoded) {
            $this->addFlash('error', 'Erreur lors du décodage de la signature.');
            return $this->redirectToRoute('fichier-upload');
        }

        // Sauvegarde de la signature
        $signatureFilename = uniqid('signature_') . '.png';
        $signaturePath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $signatureFilename;
        file_put_contents($signaturePath, $signatureDecoded);

        // Gestion des fichiers uploadés
        /** @var UploadedFile[] $files */
        $files = $request->files->all();
        $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/';

        foreach ($files as $fileArray) {
            foreach ($fileArray as $file) {
                if ($file instanceof UploadedFile) {
                    $newFilename = uniqid() . '.' . $file->guessExtension();

                    try {
                        $file->move($uploadDirectory, $newFilename);
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Erreur lors de l\'envoi du fichier.');
                        return $this->redirectToRoute('fichier-upload');
                    }
                }
            }
        }

        $this->addFlash('success', 'Fichiers et signature envoyés avec succès !');
        return $this->redirectToRoute('fichier-upload');
    }
}
