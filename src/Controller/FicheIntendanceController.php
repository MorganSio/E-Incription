<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\RegimeCantine;
use App\Repository\InfoEleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FicheIntendanceController extends AbstractController
{
    #[Route('fiche-intendance', name: 'fiche-intendance')]
    public function ficheIntendance(Request $request, EntityManagerInterface $entityManager, InfoEleveRepository $infoEleveRepository): Response
    {
        // Récupérer l'élève connecté ou par ID (à adapter selon votre logique)
        $user = $this->getUser();
        
        // Chercher l'InfoEleve correspondante ou en créer une nouvelle
        $infoEleve = $user ? $infoEleveRepository->findOneBy(['user' => $user]) : null;
    
        if (!$infoEleve) {
            throw $this->createNotFoundException('Aucune information élève trouvée pour cet utilisateur.');
        }
    
        // Vérifie si le formulaire a été soumis en POST
        if ($request->isMethod('POST')) {
            // Récupération des valeurs soumises
            $regime = $request->request->get('intendance');

            // dd($regime);

            // Mise à jour du régime en fonction de "accepter"
            $infoEleve->setRegime($regime);
    
            // Persister les modifications
            $entityManager->persist($infoEleve);
            $entityManager->flush();
    
            // Ajouter un message flash
            $this->addFlash('success', 'Informations enregistrées avec succès.');
    
            // Rediriger vers la page d'accueil ou une autre page
            return $this->redirectToRoute('index');
        }
    
        // Rendu du formulaire
        return $this->render('forms/intendance.html.twig', [
            'infoUser' => $infoEleve,
        ]);
    }
}
