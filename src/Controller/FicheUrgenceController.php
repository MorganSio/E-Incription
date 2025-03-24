<?php

namespace App\Controller;

use App\Entity\AssuranceScolaire;
use App\Entity\CentreSecuriteSociale;
use App\Entity\MedecinTraitant;
use App\Form\FicheUrgenceFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\VarDumper\Cloner\Data;

class FicheUrgenceController extends AbstractController
{
    #[Route('fiche-urgence', name: 'fiche-urgence')]
    public function ficheUrgence(Request $request,EntityManagerInterface $entityManagerInterface): Response
    {
        $infoUser = $this->getUser()->getInfoEleve();
        $secuSocial = null;

        $assurance = null;
        $medecin = null;
        $form =  $this->createForm(FicheUrgenceFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() &&$form->isValid()) {
            $data = $form->getData();

            if ($infoUser->getSecuSociale() instanceof CentreSecuriteSociale){
                $secuSocial = $infoUser->getSecuSociale();
            }
            else {
                $secuSocial = new CentreSecuriteSociale();
                $infoUser->setSecuSociale($secuSocial);
                $entityManagerInterface->persist($secuSocial);
            }

            if ($infoUser->getAssureur() instanceof AssuranceScolaire){
                $assurance = $infoUser->getAssureur();
            }
            else {
                $assurance = new AssuranceScolaire();
                $infoUser->setAssureur($assurance);
                $entityManagerInterface->persist($assurance);
            }
            
            if ($infoUser->getMedecinTraitant() instanceof MedecinTraitant){
                $medecin = $infoUser->getMedecinTraitant();
            }
            else {
                $medecin = new MedecinTraitant();
                $infoUser->setMedecinTraitant($medecin);
                $entityManagerInterface->persist($medecin);
            }

            if (isset($data['nomSecuSocial'])){
            $secuSocial->setNom($data['nomSecuSocial']);
            }
            if (isset($data['addresseSecuSocial'])){
            $secuSocial->setAddresse($data['addresseSecuSocial']);
            }
            if (isset($data['nomAssurance'])){
            $assurance->setNom($data['nomAssurance']);
            }
            if (isset($data['addresseAssurance'])){
            $assurance->setAddresse($data['addresseAssurance']);
            }
            if (isset($data['numeroAssurance'] )){
            $assurance->setNumeroAssurance($data['numeroAssurance']);
            }
            if (isset($data['nomMedecin'] )){
            $medecin->setNom($data['nomMedecin']);
            }
            if (isset($data['adresseMedecin'] )){
            $medecin->setAdresse($data['adresseMedecin']);
            }
            if (isset($data['numeroMedecin'] )){
            $medecin->setNumero($data['numeroMedecin']);    
            }
            if (isset($data['dateAntitetanique'] )){
            $infoUser->setDernierRappelAntitetanique($data['dateAntitetanique']);
            }
            if (isset($data['observation'] )){
            $infoUser->setObservations($data['observation']);
            }
            if (isset($data['nomContactUrgence'] )){
            $infoUser->setNomContacteUrgence($data['nomContactUrgence']);
            }
            if (isset($data['numContactUrgence'] )){
            $infoUser->setNumeroContacteUrgence($data['numContactUrgence']);
            }
            $entityManagerInterface->flush();
        }

        return $this->render('/forms/urgence.html.twig', [
            'FicheurgenceFormType' => $form,
        ]);
    }
}
