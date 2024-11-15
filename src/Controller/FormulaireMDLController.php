<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FormulaireMDLController extends AbstractController
{
    #[Route('/formulaire_mdl', name: 'formulaire_mdl')]
    public function index(): Response
    {
        return $this->render('index/formulaire_mdl.html.twig', [
            'controller_name' => 'FormulaireMDLController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FormulaireMDLController extends AbstractController
{
    #[Route('/formulaire_mdl', name: 'formulaire_mdl')]
    public function index(): Response
    {
        return $this->render('index/formulaire_mdl.html.twig', [
            'controller_name' => 'FormulaireMDLController',
        ]);
    }
}
