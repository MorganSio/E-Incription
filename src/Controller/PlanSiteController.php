<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlanSiteController extends AbstractController{
    #[Route('/plan_site', name: 'plan_site')]
    public function index(): Response
    {
        return $this->render('autre/plan_site.html.twig', [
            'controller_name' => 'PlanSiteController',
        ]);
    }
}
