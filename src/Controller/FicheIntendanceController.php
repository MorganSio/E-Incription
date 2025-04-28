<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\RegimeCantine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FicheIntendanceController extends AbstractController
{
    #[Route('fiche-intendance', name: 'fiche-intendance')]
    public function index(): Response
    {
        return $this->render('/forms/intendance.html.twig', [
            'controller_name' => 'FicheIntendanceController',
        ]);
    }

    public function ficheIntendance(Request $request, EntityManagerInterface $entityManager): Response
    {
        $infoUser = $this->getUser()->getInfoEleve();

        if ($request->isMethod('POST')) {
            $accepter = $request->request->get('accepter');

            if ($accepter === 'oui') {
                $regime = $entityManager->getRepository(RegimeCantine::class)->findOneBy(['label' => 'tickets']);
                if ($regime) {
                    $infoUser->setRegime($regime);
                }
            } elseif ($accepter === 'non') {
                $regime = $entityManager->getRepository(RegimeCantine::class)->findOneBy(['label' => 'externe']);
                if ($regime) {
                    $infoUser->setRegime($regime);
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Votre choix a bien été enregistré.');
            return $this->redirectToRoute('fiche-intendance');
        }

        return $this->render('forms/intendance.html.twig', [
            'infoUser' => $infoUser,
        ]);
    }
}
