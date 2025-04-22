<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\InfoEleve;
use App\Repository\InfoEleveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormulaireMDLController extends AbstractController
{
    #[Route('/fiche-mdl', name: 'fiche-mdl')]
    public function index(Request $request, EntityManagerInterface $entityManager, InfoEleveRepository $infoEleveRepository): Response
    {
        // Récupérer l'élève connecté ou par ID (à adapter selon votre logique)
        $user = $this->getUser();
        
        // // Chercher l'InfoEleve correspondante ou en créer une nouvelle
        $infoEleve = $user ? $infoEleveRepository->findOneBy(['user' => $user]) : null;

        // $infoEleve = $this -> getUser() -> getInfoEleve();
        // if (!$infoEleve) {
        //     $infoEleve = new InfoEleve();
        //     // Si nouvelle entité, associer à l'utilisateur si nécessaire
        //     if ($user) {
        //         $infoEleve->setUser($user);
        //     }
        // }
        
        // Vérifie si le formulaire a été soumis en POST
        if ($request->isMethod('POST')) {
            // Récupération des valeurs soumises
            $accepter = $request->request->get('accepter');
            $paymentMethod = $request->request->get('payment_method');
            $imageRights = $request->request->get('image_rights');
            
            // Mise à jour de l'entité InfoEleve
            $infoEleve->setDroitImage($imageRights);
            $infoEleve->setCheque($paymentMethod);
            
            // Persister les modifications
            $entityManager->persist($infoEleve);
            $entityManager->flush();
            
            // Ajouter un message flash
            $this->addFlash('success', 'Informations enregistrées avec succès.');
            
            // Rediriger vers la page d'accueil ou une autre page
            return $this->redirectToRoute('index');
        }

        // Si ce n'est pas une soumission POST, affiche le formulaire
        return $this->render('forms/mdl.html.twig', [
            'controller_name' => 'FormulaireMDLController',
            'info_eleve' => $infoEleve,
        ]);
    }
}