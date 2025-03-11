<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FicheUrgenceController extends AbstractController
{
    #[Route('fiche-urgence', name: 'fiche-urgence')]
    public function index(): Response
    {
        return $this->render('/forms/urgence.html.twig', [
            'controller_name' => 'FicheUrgenceController',
        ]);
    }
}
