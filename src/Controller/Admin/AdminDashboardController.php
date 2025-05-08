<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\CompletionCheckerService;
use App\Service\GraphMailer;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractDashboardController
{
    private const CC_EMAIL = 'rouff.hugo28@gmail.com';

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly GraphMailer $graphMailer,
        private readonly CompletionCheckerService $completionChecker,
        private readonly LoggerInterface $logger,
    ) {}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->redirectToRoute('admin_dashboard');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('E-Inscription');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
        yield MenuItem::linkToRoute('Sortir', 'fas fa-sign-out-alt', 'index');
    }

    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function dashboard(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/user/{id}/toggle-verification', name: 'admin_toggle_verification', methods: ['POST'])]
    public function toggleVerification(User $user, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('toggle_verification_' . $user->getId(), $request->request->get('_token'))) {
            $user->setVerified(!$user->isVerified());
            $this->entityManager->flush();
            $this->addFlash('success', 'Le statut de vérification a été mis à jour.');
        }

        return $this->redirectToRoute('admin_dashboard');
    }

    #[Route('/admin/envoyer-email/{id}', name: 'admin_email_form')]
    public function emailForm(User $user): Response
    {
        return $this->render('admin/email.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/admin/send-email/{id}', name: 'admin_send_email', methods: ['POST'])]
    public function sendEmail(Request $request, User $user): Response
    {
        $objet = trim($request->request->get('objet'));
        $message = trim($request->request->get('message'));
        $cc = self::CC_EMAIL;

        if (!$objet || !$message) {
            $this->addFlash('error', 'Veuillez remplir tous les champs obligatoires.');
            return $this->redirectToRoute('admin_email_form', ['id' => $user->getId()]);
        }

        $attachments = [];
        $allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'image/jpeg',
            'image/png',
            'text/xml'
        ];

        foreach ($request->files->get('attachments', []) as $file) {
            if ($file && $file->isValid()) {
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    $this->addFlash('error', 'Fichier non autorisé : ' . $file->getClientOriginalName());
                    return $this->redirectToRoute('admin_email_form', ['id' => $user->getId()]);
                }

                if ($file->getSize() > 3 * 1024 * 1024) {
                    $this->addFlash('error', 'Le fichier ' . $file->getClientOriginalName() . ' dépasse la limite de 3 Mo.');
                    return $this->redirectToRoute('admin_email_form', ['id' => $user->getId()]);
                }

                $attachments[] = [
                    '@odata.type' => '#microsoft.graph.fileAttachment',
                    'name' => $file->getClientOriginalName(),
                    'contentType' => $file->getMimeType(),
                    'contentBytes' => base64_encode(file_get_contents($file->getPathname())),
                ];
            }
        }

        $success = $this->graphMailer->sendMail(
            $user->getEmail(),
            $objet,
            $message,
            $cc,
            $attachments
        );

        if (!$success) {
            $this->addFlash('error', 'Erreur lors de l\'envoi de l\'email.');
        } else {
            $this->addFlash('success', 'L\'email a été envoyé avec succès.');
        }

        return $this->redirectToRoute('admin_dashboard');
    }

    #[Route('/admin/visualiser-donnees/{id}', name: 'admin_visualiser_donnees')]
    public function visualiserDonnees(User $user): Response
    {
        $completionData = $this->completionChecker->analyzeStudentDataCompletion($user);
        $documents = $this->completionChecker->checkRequiredDocuments($user, $this->getParameter('kernel.project_dir'));
        $globalStats = $this->completionChecker->getGlobalStatistics();

        return $this->render('admin/donnee.html.twig', [
            'user' => $user,
            'completionData' => [
                'completion' => [
                    'complete' => $completionData['global']['complete'],
                    'incomplete' => $completionData['global']['incomplete'],
                ],
                'sectionData' => array_map(fn ($sectionData) => [
                    'complete' => $sectionData['complete'],
                    'incomplete' => $sectionData['incomplete'],
                ], $completionData['sections']),
                'missingFields' => array_slice($completionData['missing_fields'], 0, 10),
            ],
            'documents' => $documents,
            'globalComparison' => [
                'user_percentage' => $completionData['completion_percentage'],
                'global_average' => $globalStats['completion_average'],
            ],
            'pdfs' => $documents['pdfs'],
        ]);
    }

    #[Route('/admin/relancer-eleves', name: 'admin_relancer_eleves')]
    public function relancerEleves(): Response
    {
        $users = $this->userRepository->findAll();
        $relanceStats = ['total' => count($users), 'relances' => 0, 'complets' => 0];

        foreach ($users as $user) {
            $completionData = $this->completionChecker->analyzeStudentDataCompletion($user);

            if ($completionData['completion_percentage'] < 80) {
                if ($this->graphMailer->sendMail(
                    $user->getEmail(),
                    'Dossier incomplet - Action requise',
                    'Votre dossier est incomplet. Merci de vous connecter et de le compléter.',
                    self::CC_EMAIL
                )) {
                    $relanceStats['relances']++;
                } else {
                    $this->logger->error("Échec d’envoi de mail à " . $user->getEmail());
                }
            } else {
                $relanceStats['complets']++;
            }
        }

        $this->addFlash('success', sprintf(
            '%d relances envoyées. %d dossiers sont complets.',
            $relanceStats['relances'],
            $relanceStats['complets']
        ));

        return $this->redirectToRoute('admin_dashboard');
    }

    #[Route('/admin/test-email', name: 'admin_test_email')]
    public function testEmail(): Response
    {
        if (!$this->graphMailer->sendMail(
            'hugo.rouff@lyceefulbert.fr',
            'Test de configuration du mailer',
            'Ceci est un email de test pour vérifier la configuration OAuth2.',
            self::CC_EMAIL
        )) {
            $this->addFlash('error', 'Échec lors de l’envoi de l’email de test.');
        } else {
            $this->addFlash('success', 'L\'email de test a été envoyé avec succès.');
        }

        return $this->redirectToRoute('admin_dashboard');
    }
}