<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MentionsLegalesController extends AbstractController
{
    #[Route('mentions-legales', name: 'mentions_legales')]
    public function index(): Response
    {
        return $this->render('/autre/mentions.html.twig', [
            'controller_name' => 'MentionsLegalesController',
        ]);
    }
}
