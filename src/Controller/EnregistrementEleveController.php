<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EnregistrementEleveController extends AbstractController
{
    #[Route('/info-eleve', name: 'fiche-etudiant')]
    public function index(): Response
    {
        return $this->render('enregistrement_eleve/index.html.twig', [
            'controller_name' => 'EnregistrementEleveController',
        ]);
    }
}
