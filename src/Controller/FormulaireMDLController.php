<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class FormulaireMDLController extends AbstractController
{
    #[Route('/formulaire_mdl', name: 'formulaire_mdl')]
    public function index(): Response
    {
        return $this->render('index/formulaire_mdl.html.twig', [
            'controller_name' => 'FormulaireMDLController',
        ]);
    }
    public function adhesion(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $accepted = $request->request->get('accepter') === 'oui';
            $paymentMethod = $request->request->get('payment_method', null);
            $imageRights = $request->request->get('image_rights', null) === 'authorize';

            if ($accepted) {
                $adhesion = new Adhesion();
                $adhesion->setAccepted(true);
                $adhesion->setPaymentMethod($paymentMethod);
                $adhesion->setImageRights($imageRights);

                $entityManager->persist($adhesion);
                $entityManager->flush();

                $this->addFlash('success', 'Votre adhésion a été enregistrée !');
                return $this->redirectToRoute('formualire_mdl'); // Redirection ou autre route
            }

            $this->addFlash('error', 'Vous avez refusé d\'adhérer à la MDL.');
        }

        return $this->render('formulaire_mdl.html.twig');
    }
}
