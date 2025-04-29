<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\User;
use App\Entity\Langues;
use App\Entity\InfoEleve;
use App\Entity\RepresentantLegal;
use App\Entity\ScolariteAnterieur;
use App\Repository\LanguesRepository;
// use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EnregistrementEleveController extends AbstractController
{
    #[Route('/info-eleve', name: 'fiche-etudiant')]
    public function index(): Response
    {
        
    // dd("2025-04-24");
    // dd(\DateTime::createFromFormat("Y-m-d","2025-04-24"));
        return $this->render('enregistrement_eleve/index.html.twig', [
            'controller_name' => 'EnregistrementEleveController',
        ]);

    }
    
    #[Route('/info-eleve/save' ,name: 'save_info_eleve', methods: ['POST'])]
    public function save(Request $request, EntityManagerInterface $entityManager) : JsonResponse #*/
    {
        $data = json_decode($request->getContent(),true);

        if (!$data) {
            return new JsonResponse(['success' => false, 'message' => 'donnée invalides ou non récupérée'], 400);
        }
        

        try {
            // $infoEleve = new InfoEleve(new User());
            $infoEleve = $this->getUser()->getInfoEleve();

            if ($infoEleve->getAnneScolaireUn() instanceof ScolariteAnterieur){
                $anneScolaireUn = $infoEleve->getAnneScolaireUn();
            }
            else {
                $anneScolaireUn = new ScolariteAnterieur();
                $entityManager->persist($anneScolaireUn);
                $infoEleve->setAnneScolaireUn($anneScolaireUn);
            }
            if ($infoEleve->getAnneScolaireDeux() instanceof ScolariteAnterieur){
                $anneScolaireDeux = $infoEleve->getAnneScolaireDeux();
            }
            else {
                $anneScolaireDeux = new ScolariteAnterieur();
                $entityManager->persist($anneScolaireDeux);
                $infoEleve->setAnneScolaireDeux($anneScolaireDeux);
            }

            { // langues
                $label = $data["lv1-1"] ;
                $langueRepo = $entityManager->getRepository(get_class(new Langues));
                if (!$label = ""){
                    $langue = $langueRepo->findOneBy(array("label" => $label ));
                    if(is_null($langue)){
                        $langue = new Langues();
                        $langue->setLabel($label);
                        $entityManager->persist($langue);
                    }
                    if ($anneScolaireUn->getLVUn() instanceof Langues) {
                        $lv1A1 = $anneScolaireUn->getLVUn();
                        if ($langue != $lv1A1) {
                            $anneScolaireUn->setLVUn($langue);
                        }
                    }
                    else {
                        $anneScolaireUn->setLVUn($langue);
                    }
                }

                $label = $data["lv1-2"] ;
                if (!$label = ""){
                    $langue = $langueRepo->findOneBy(array("label" => $label ));
                    
                    if(is_null($langue)){
                        $langue = new Langues();
                        $langue->setLabel($label);
                        $entityManager->persist($langue);
                    }
                    if ($anneScolaireDeux->getLVUn() instanceof Langues) {
                        $lv1A2 = $anneScolaireDeux->getLVUn();
                        if ($langue != $lv1A2) {
                            $anneScolaireDeux->setLVUn($langue);
                        }
                    }
                    else {
                        $anneScolaireDeux->setLVUn($langue);
                    }
                }

                $label = $data["lv2-1"] ;
                if (!$label = ""){
                    $langue = $langueRepo->findOneBy(array("label" => $label ));
                    
                    if(is_null($langue)){
                        $langue = new Langues();
                        $langue->setLabel($label);
                        $entityManager->persist($langue);
                    }
                    if ($anneScolaireUn->getLVDeux() instanceof Langues) {
                        $lv2A1 = $anneScolaireUn->getLVDeux();
                        if ($langue != $lv2A1) {
                            $anneScolaireUn->setLVDeux($langue);
                        }
                    }
                    else {
                        $anneScolaireUn->setLVDeux($langue);
                    }
                }

                $label = $data["lv2-2"] ;
                if (!$label = ""){
                    $langue = $langueRepo->findOneBy(array("label" => $label ));
                    
                    if(is_null($langue)){
                        $langue = new Langues();
                        $langue->setLabel($label);
                        $entityManager->persist($langue);
                    }
                    if ($anneScolaireDeux->getLVDeux() instanceof Langues) {
                        $lv2A2 = $anneScolaireDeux->getLVDeux();
                        if ($langue != $lv2A2) {
                            $anneScolaireDeux->setLVDeux($langue);
                        }
                    }
                    else {
                        $anneScolaireDeux->setLVDeux($langue);
                    }
                }

                $label = $data["student-lv1"];
                if ($label != "") {
                    $langue = $langueRepo->findOneBy(array("label" => $label ));
                    
                    if(is_null($langue)){
                        return new JsonResponse(['success' => false, 'message' => "LV1 pour l'annee a venir non valide"],400);
                    }
                    $infoEleve->setLVUn($langue);
                }
                $label = $data["student-lv2"];
                if ($label != "") {
                    $langue = $langueRepo->findOneBy(array("label" => $label ));
                    if(is_null($langue)){
                        return new JsonResponse(['success' => false, 'message' => "LV2 pour l'annee a venir non valide"],400);
                    }
                    $infoEleve->setLVDeux($langue);
                }
            }

            if ($data["annee-1"] != ""){
                $anneScolaireUn->setAnneScolaire($data["annee-1"]);
            }
            if ($data["annee-2"] != ""){
                $anneScolaireDeux->setAnneScolaire($data["annee-2"]);
            }

            if ($data["classe-1"] != "") {
                $anneScolaireUn->setClasse($data["classe-1"]);
            }

            if ($data["classe-2"] != "") {
                $anneScolaireDeux->setClasse($data["classe-2"]);
            }

            if ($data["etablissement-1"] != "") {
                $anneScolaireUn->setEtablissement($data["etablissement-1"]);
            }

            if ($data["etablissement-2"] != "") {
                $anneScolaireDeux->setEtablissement($data["etablissement-2"]);
            }

            if ($data["immatriculation"] != "") {
                $infoEleve->setImmattriculationVeic($data["immatriculation"]);
            }

            if ($data["last-certif"] != "") {
                $infoEleve->setDernierDiplome($data["last-certif"]);
            }
            if ($data["option-1"] != "") {
                $anneScolaireUn->setOption($data["option-1"]);
            }

            if ($data["option-2"] != "") {
                $anneScolaireDeux->setOption($data["option-2"]);
            }

            if ($data["student-birth-city"] != "") {
                $infoEleve->setCommuneNaissance($data["student-birth-city"]);
            }
            if ($data["student-birth-dept"] != "") {
                $infoEleve->setDepartement($data["student-birth-city"]);
            }
            if ($data["student-birthdate"] != "") {
                $infoEleve->setDateDeNaissance(\DateTime::createFromFormat("Y-m-d",$data["student-birthdate"]));
            }
            if ($data["student-class"] != "") {
                $infoEleve->setClasse($entityManager->getRepository(get_class(new Classe))->findOneBy(array("label" => $data["student-class"])));
            }

            if ($data["student-mobile"] != "") {
                $infoEleve->setNumeroMobile($data["student-mobile"]);
            }

            if ($data["student-natio"] != "") {
                $infoEleve->setNationalite($data["student-natio"]);
            }

            if ($data["student-redoubling"] != "") {
                if($data["student-redoubling"] == "oui"){
                    $infoEleve->setRedoublant(true);
                }
                else {
                    $infoEleve->setRedoublant(false);
                }
            }

            if ($data["student-secu"] != "") {
                $infoEleve->setNumSecuSocial($data["student-secu"]);
            }

            if ($data["student-has-transport"] == "true") {
                $infoEleve->setTransportScolaire($data["student-transport"]);

                if (isset($data["immatriculation"]) and $data["student-transport"] == "voiture-transport") {
                    $infoEleve->setImmattriculationVeic($data["immatriculation"]);
                }
            }

            if (isset($data['student-legal']) and $data['student-legal'] == "true"){
                $user = $this->getUser();
                // $user = new User;
                if ($infoEleve->getResponsableUn() instanceof RepresentantLegal){
                    $representantUn = $infoEleve->getResponsableUn();
                }
                else {
                    $representantUn = new RepresentantLegal();
                    $representantUn->setNom($user->getNom());
                    $representantUn->setPrenom($user->getPrenom());
                    $entityManager->persist($representantUn);
                    $infoEleve->setResponsableUn($representantUn);
                    $representantUn->setInfoEleve($infoEleve);
                }
                if ($data["resp-codepostal"] != "") {
                    $representantUn->setCodePostal($data["resp-codepostal"]);
                }
                if ($data["resp-comm"] != "") {
                    if ($data["resp-comm"]  == "oui"){
                        $representantUn->setComAddrAsso(true);
                    }
                    else {
                        $representantUn->setComAddrAsso(false);
                    }
                }

                if ($data["resp-email"] != "") {
                    $representantUn->setCourriel($data["resp-email"]);
                }
                if ($data["resp-commune"] != "") {
                    $representantUn->setCommune($data["resp-commune"]);
                }
                if ($data["resp-adresse"] != "") {
                    $representantUn->setAdresse($data["resp-adresse"]);
                }
                if ($data["resp-phone"] != "") {
                    $representantUn->setTelephonePerso($data["resp-phone"]);
                }
                if ($data["resp-phone-dom"] != "") {
                    $representantUn->setTelephoneFixe($data["resp-phone-dom"]);
                }
            }
            
            $entityManager->flush();
            return new JsonResponse(['success' => true, 'message' => 'donée récupérée et traité'],200);
        }
        catch (\Exception $error) {
            return new JsonResponse(['success' => false, 'message' => 'Erreur : ' . $error->getMessage()], 500);
        }
    }

}
