<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FicheIntendanceController extends AbstractController
{
    #[Route('/fiche/intendance', name: 'fiche_intendance')]
    public function index(): Response
    {
        return $this->render('fiche_intendance/index.html.twig', [
            'controller_name' => 'FicheIntendanceController',
        ]);
    }
}
