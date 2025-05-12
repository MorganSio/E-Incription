<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PolitiqueConfidentialiteController extends AbstractController{
    #[Route('/politique-confidentialite', name: 'politique_confidentialite')]
    public function index(): Response
    {
        return $this->render('autre/politique_confidentialite.html.twig', [
            'controller_name' => 'PolitiqueConfidentialiteController',
        ]);
    }
}
