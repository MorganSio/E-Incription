<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FicheUrgenceController extends AbstractController
{
    #[Route('/fiche-urgence', name: 'fiche-urgence')]
    public function index(): Response
    {
        return $this->render('fiche_urgence/index.html.twig', [
            'controller_name' => 'FicheUrgenceController',
        ]);
    }
}
