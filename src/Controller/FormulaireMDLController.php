<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormulaireMDLController extends AbstractController
{
    #[Route('/fiche-mdl', name: 'fiche-mdl')]
    public function index(Request $request): Response
    {
        // Vérifie si le formulaire a été soumis en POST
        if ($request->isMethod('POST')) {
            // Récupération des valeurs soumises
            $accepter = $request->request->get('accepter');
            $paymentMethod = $request->request->get('payment_method');
            $imageRights = $request->request->get('image_rights');
  
            $data = [
                'accepter'      => $accepter,
                'payment_method'=> $paymentMethod,
                'image_rights'  => $imageRights,
            ];
            
            // Affiche les données dans le profiler Symfony (barre de debug)
            // Note: dd() interrompt l'exécution, à supprimer en production
            dd($data);

            // Optionnel : ajouter un message flash, rediriger, etc.
            $this->addFlash('success', 'Formulaire traité avec succès.');
            return $this->redirectToRoute('index');
        }

        // Si ce n'est pas une soumission POST, affiche le formulaire
        return $this->render('forms/mdl.html.twig', [
            'controller_name' => 'FormulaireMDLController',
        ]);
    }
}
