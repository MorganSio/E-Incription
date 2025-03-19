<?php

namespace App\Controller;

use App\Entity\RepresentantLegal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AccedeRepresentantRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RepresentantLegalControlller extends AbstractController
{
    #[Route('/fiche-representant-legal', name: 'fiche-representant-legal')]
    public function index(): Response
    {
        return $this->render('forms/representant_legal.html.twig', [
            'controller_name' => 'RepresentantLegalControlller',
        ]);
    }

    #[Route('/representant/legal/save', name: 'save_representant_legal', methods: ['POST'])]
    public function save(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (!$data) {
            return new JsonResponse(['success' => false, 'message' => 'Données invalides'], 400);
        }

        try {
            $infoEleve = $this->getUser()->getInfoEleve;
            if ($infoEleve->getResponsableUn() instanceof RepresentantLegal){
                $representantUn = $infoEleve->getResponsableUn();
            }
            else {
                $representantUn = new RepresentantLegal();
                $entityManager->persist($representantUn);
            }
            
            if ($infoEleve->getResponsableDeux() instanceof RepresentantLegal){
                $representantDeux = $infoEleve->getResponsableDeux();                
            }
            else {
                $representantDeux = new RepresentantLegal();
                $entityManager->persist($representantDeux);
            }
            
            $representantUn->setTelephoneFixe($data['telephone_fixe'] ?? null);
            $representantUn->setTelephonePro($data['telephone_pro'] ?? null);
            $representantUn->setPoste($data['poste'] ?? null);
            $representantUn->setNomEmployeur($data['nom_employeur'] ?? null);
            $representantUn->setAdresseEmployeur($data['adresse_employeur'] ?? null);
            $representantUn->setRIB($data['RIB'] ?? null);

            $entityManager->flush();

            return new JsonResponse(['success' => true, 'message' => 'Représentant légal enregistré avec succès']);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
        }
    }
}
