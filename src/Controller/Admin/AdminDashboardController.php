<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Service\CompletionCheckerService;

class AdminDashboardController extends AbstractDashboardController
{
    private UserRepository $userRepository;
    private $entityManager;
    private $mailer;
    private $completionChecker;

    public function __construct(
        UserRepository $userRepository, 
        EntityManagerInterface $entityManager, 
        MailerInterface $mailer,
        CompletionCheckerService $completionChecker
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->completionChecker = $completionChecker;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'users' => $users
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('E Inscription');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
        yield MenuItem::linkToRoute('Sortir', 'fas fa-sign-out-alt', 'index');
    }

    #[Route('/admin/user/{id}/toggle-verification', name: 'admin_toggle_verification', methods: ['POST'])]
    public function toggleVerification(User $user, EntityManagerInterface $em, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('toggle_verification_' . $user->getId(), $request->request->get('_token'))) {
            $user->setVerified(!$user->isVerified());
            $em->flush();

            $this->addFlash('success', 'Le statut de vérification a été mis à jour.');
        }

        return $this->redirectToRoute('admin_dashboard');
    }

    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function dashboard(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        
        return $this->render('admin/dashboard.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/admin/envoyer-email/{id}', name: 'admin_email_form')]
    public function emailForm(User $user): Response
    {
        return $this->render('admin/email.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * Traite l'envoi d'email
     */
    #[Route('/admin/send-email/{id}', name: 'admin_send_email', methods: ['POST'])]
    public function sendEmail(Request $request, User $user): Response
    {
        $objet = $request->request->get('objet');
        $message = $request->request->get('message');
        
        // Validation simple
        if (empty($objet) || empty($message)) {
            $this->addFlash('error', 'Veuillez remplir tous les champs');
            return $this->redirectToRoute('admin_email_form', ['id' => $user->getId()]);
        }
        
        // Création et envoi de l'email
        $email = (new Email())
            ->from('hugo.rouff@lyceefulbert.fr')
            ->to($user->getEmail())
            ->subject($objet)
            ->html($message);
            
        $this->mailer->send($email);
        
        $this->addFlash('success', 'L\'email a été envoyé avec succès');
        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * Affiche la visualisation des données avec un diagramme pour un utilisateur
     */
    #[Route('/admin/visualiser-donnees/{id}', name: 'admin_visualiser_donnees')]
    public function visualiserDonnees(User $user): Response
    {
        // Analyse des données de l'élève avec le service dédié
        $completionData = $this->completionChecker->analyzeStudentDataCompletion($user);
        
        // Vérification des documents requis
        $documents = $this->completionChecker->checkRequiredDocuments(
            $user, 
            $this->getParameter('kernel.project_dir')
        );
        
        // Récupération des statistiques globales pour comparer
        $globalStats = $this->completionChecker->getGlobalStatistics();
        
        // Préparation des données pour les graphiques
        $chartData = [
            'completion' => [
                'complete' => $completionData['global']['complete'],
                'incomplete' => $completionData['global']['incomplete']
            ],
            'sectionData' => array_map(function($sectionData) {
                return [
                    'complete' => $sectionData['complete'], 
                    'incomplete' => $sectionData['incomplete']
                ];
            }, $completionData['sections']),
            'missingFields' => array_slice($completionData['missing_fields'], 0, 10) // Top 10 des champs manquants
        ];
        
        return $this->render('admin/donnee.html.twig', [
            'user' => $user,
            'completionData' => $chartData,
            'documents' => $documents,
            'globalComparison' => [
                'user_percentage' => $completionData['completion_percentage'],
                'global_average' => $globalStats['completion_average']
            ],
            'pdfs' => $documents['pdfs']
        ]);
    }
    public function statistiquesGlobales(): Response
    {
        $globalStats = $this->completionChecker->getGlobalStatistics();
        
        return $this->render('admin/donnee.html.twig', [
            'globalStats' => $globalStats,
            'missingFieldsCount' => array_slice($globalStats['missing_fields'], 0, 15), // Top 15 des champs manquants
        ]);
    }

    public function relancerEleves(): Response
    {
        $users = $this->userRepository->findAll();
        $relanceStats = [
            'total' => count($users),
            'relances' => 0,
            'complets' => 0
        ];
        
        foreach ($users as $user) {
            $completionData = $this->completionChecker->analyzeStudentDataCompletion($user);
            
            // Si moins de 80% de complétion, on relance
            if ($completionData['completion_percentage'] < 80) {
                // Liste des champs manquants à inclure dans l'email
                $champsManquants = array_map(function($field) {
                    return $field['section'] . ' > ' . $field['field'];
                }, $completionData['missing_fields']);
                
                // Construction du message de relance
                $message = $this->renderView('admin/donnee.html.twig', [
                    'user' => $user,
                    'champs_manquants' => $champsManquants,
                    'pourcentage_completion' => $completionData['completion_percentage']
                ]);
                
                // Envoi de l'email
                $email = (new Email())
                    ->from('hugo.rouff@lyceefulbert.fr')
                    ->to($user->getEmail())
                    ->subject('Dossier incomplet - Action requise')
                    ->html($message);
                
                $this->mailer->send($email);
                $relanceStats['relances']++;
            } else {
                $relanceStats['complets']++;
            }
        }
        
        $this->addFlash('success', sprintf(
            '%d élèves ont été relancés. %d élèves ont un dossier suffisamment complet.',
            $relanceStats['relances'],
            $relanceStats['complets']
        ));
        
        return $this->redirectToRoute('admin_dashboard');
    }
}