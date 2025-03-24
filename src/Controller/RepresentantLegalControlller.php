<?php

namespace App\Controller;

use App\Entity\RepresentantLegal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function PHPUnit\Framework\isNull;

class RepresentantLegalControlller extends AbstractController
{
    #[Route('/fiche-representant-legal', name: 'fiche-representant-legal')]
    public function index(): Response
    {
        return $this->render('representant_legal/index.html.twig', [
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
            $infoUser = $this->getUser()->getInfoEleve();


            if ($data['repNumber'] == '1'){
                


                if ($infoUser->getResponsableUn() instanceof RepresentantLegal){
                    $representantUn = $infoUser->getResponsableUn();
                }
                else {
                    $representantUn = new RepresentantLegal();
                    $entityManager->persist($representantUn);
                    $infoUser->setResponsableUn($representantUn);
                    $representantUn->setInfoEleve($infoUser);
                }
                if ($data["telephone_mobile1"] != ""){
                    $representantUn->setTelephonePerso($data["telephone_mobile1"]);
                }
                if ($data['telephone_domicile1'] != ""){
                    $representantUn->setTelephoneFixe($data['telephone_domicile1']);
                }
                if ($data['family-name'] != ""){
                    $representantUn->setNom($data['family-name']);
                }
    
                if ($data["given-name"] != ""){
                    $representantUn->setPrenom($data["given-name"]);
                }
            
                if ($data["courriel1"] != ""){
                    $representantUn->setCourriel($data["courriel1"]);
                }

                if (isset($data['sms1']))
                {
                    $representantUn->setSmsSend($data['sms1']);
                }
                else{
                    $representantUn->setSmsSend(false);
                }
                if (isset($data['lien1'])){
                    $representantUn->setLienEleve($data['lien1']);
                }
                if (isset($data['autorisation1'])){
                    if ($data['autorisation1'] == 'oui'){
                        $representantUn->setComAddrAsso(true);
                    }
                    else {
                        $representantUn->setComAddrAsso(false);                    
                    }
                }
                if ($data['telephone_travail1'] != ""){
                    $representantUn->setTelephonePro($data['telephone_travail1']);
                }               
                
                if ($data['profession1'] != ""){
                    $representantUn->setPoste($data['profession1']);
                }
                if ($data['nom_employeur1'] != ""){
                    $representantUn->setNomEmployeur($data['nom_employeur1']);
                }
                if ($data['adresse_employeur1'] != ""){
                    $representantUn->setAdresseEmployeur($data['adresse_employeur1']);
                }
                if ($data['addresse-voie1'] != "" ){
                    $representantUn->setAdresse($data['addresse-voie1']);
                // has a probem with citypostal-cod
                }
                if ($data['postal-code1'] != "" ){
                    $representantUn->setCodePostal($data['postal-code1']);
                }
                if ($data['addresse-city1'] != ""){
                    $representantUn->setCommune($data['addresse-city1']);   
                }
            }

            if ($data['repNumber'] == '2'){
            if ($infoUser->getResponsableDeux() instanceof RepresentantLegal){
                $representantDeux = $infoUser->getResponsableDeux();                
            }
            else {
                $representantDeux = new RepresentantLegal();
                $entityManager->persist($representantDeux);
                $infoUser->setResponsableDeux($representantDeux);
                $representantDeux->setInfoEleve($infoUser);
            }
            if ($data["telephone_mobile2"] != ""){
                $representantDeux->setTelephonePerso($data["telephone_mobile2"]);
            }
            if ($data['telephone_domicile2'] != ""){
                $representantDeux->setTelephoneFixe($data['telephone_domicile2']);
            }
            if ($data['family-name'] != ""){
                $representantDeux->setNom($data['family-name']);
            }

            if ($data["given-name"] != ""){
                $representantDeux->setPrenom($data["given-name"]);
            }
        
            if ($data["courriel2"] != ""){
                $representantDeux->setCourriel($data["courriel2"]);
            }

            if (isset($data['sms2']))
            {
                $representantDeux->setSmsSend($data['sms2']);
            }
            else{
                $representantDeux->setSmsSend(false);
            }
            if (isset($data['lien2'])){
                $representantDeux->setLienEleve($data['lien2']);
            }
            if (isset($data['autorisation2'])){
                if ($data['autorisation2'] == 'oui'){
                    $representantDeux->setComAddrAsso(true);
                }
                else {
                    $representantDeux->setComAddrAsso(false);                    
                }
            }
            if ($data['telephone_travail2'] != ""){
                $representantDeux->setTelephonePro($data['telephone_travail2']);
            }               
            
            if ($data['profession2'] != ""){
                $representantDeux->setPoste($data['profession2']);
            }
            if ($data['nom_employeur2'] != ""){
                $representantDeux->setNomEmployeur($data['nom_employeur2']);
            }
            if ($data['adresse_employeur2'] != ""){
                $representantDeux->setAdresseEmployeur($data['adresse_employeur2']);
            }
            if ($data['addresse-voie2'] != "" ){
                $representantDeux->setAdresse($data['addresse-voie2']);
            // has a probem with citypostal-cod
            }
            if ($data['postal-code2'] != "" ){
                $representantDeux->setCodePostal($data['postal-code2']);
            }
            if ($data['addresse-city2'] != ""){
                $representantDeux->setCommune($data['addresse-city2']);   
            }
            }
            $entityManager->flush();

            return new JsonResponse(['success' => true, 'message' => 'Représentant légal enregistré avec succès']);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
        }
    }
}
