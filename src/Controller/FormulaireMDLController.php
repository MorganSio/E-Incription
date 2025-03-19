<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class FormulaireMDLController extends AbstractController
{
    #[Route('fiche-mdl', name: 'fiche-mdl')]
    public function index(): Response
    {
        return $this->render('/forms/mdl.html.twig', [
            'controller_name' => 'FormulaireMDLController',
        ]);
    }
}