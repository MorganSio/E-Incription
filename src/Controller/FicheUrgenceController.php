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
            $secuSocial->setNom($data['nomSecuSocial']);
            $secuSocial->setAddresse($data['addresseSecuSocial']);

            $assurance->setNom($data['nomAssurance']);
            $assurance->setAddresse($data['addresseAssurance']);
            $assurance->setNumeroAssurance($data['numeroAssurance']);

            $medecin->setNom($data['nomMedecin']);
            $medecin->setAdresse($data['adresseMedecin']);
            $medecin->setNumero($data['numeroMedecin']);    

            $infoUser->setDernierRappelAntitetanique($data['dateAntitetanique']);
            $infoUser->setObservations($data['observation']);
            $infoUser->setNomContacteUrgence($data['nomContactUrgence']);
            $infoUser->setNumeroContacteUrgence($data['numContactUrgence']);
            $entityManagerInterface->flush();
        }

        return $this->render('/forms/urgence.html.twig', [
            'FicheurgenceFormType' => $form,
        ]);
    }
}
