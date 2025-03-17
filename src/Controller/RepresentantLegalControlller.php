<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AccedeRepresentantRepository;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\RepresentantLegal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
    public function save(Request $request, EntityManagerInterface $entityManager, AccedeRepresentantRepository $accedeRepresentantRepo): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['success' => false, 'message' => 'Données invalides'], 400);
        }

        try {
            $representant = new RepresentantLegal();
            $representant->setTelephoneFixe($data['telephone_fixe'] ?? null);
            $representant->setTelephonePro($data['telephone_pro'] ?? null);
            $representant->setPoste($data['poste'] ?? null);
            $representant->setNomEmployeur($data['nom_employeur'] ?? null);
            $representant->setAdresseEmployeur($data['adresse_employeur'] ?? null);
            $representant->setRIB($data['RIB'] ?? null);

            // Associer le représentant à un AccedeRepresentant si ID fourni
            if (!empty($data['accede_representant_id'])) {
                $accedeRepresentant = $accedeRepresentantRepo->find($data['accede_representant_id']);
                if ($accedeRepresentant) {
                    $representant->setAccedeRepresentant($accedeRepresentant);
                }
            }

            $entityManager->persist($representant);
            $entityManager->flush();

            return new JsonResponse(['success' => true, 'message' => 'Représentant légal enregistré avec succès']);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
        }
    }
}
