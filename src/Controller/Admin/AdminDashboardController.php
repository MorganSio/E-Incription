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

class AdminDashboardController extends AbstractDashboardController
{
    private UserRepository $userRepository;
    private $entityManager;
    private $mailer;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
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
            ->setTitle('E Incription');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Acceuil', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
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
            ->from('hugorouff@lyceefulbert.fr')
            ->to($user->getEmail())
            ->subject($objet)
            ->html($message);
            
        $this->mailer->send($email);
        
        $this->addFlash('success', 'L\'email a été envoyé avec succès');
        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * Affiche la visualisation des données avec un diagramme
     */
    #[Route('/admin/visualiser-donnees/{id}', name: 'admin_visualiser_donnees')]
    public function visualiserDonnees(User $user): Response
    {
        // Calcul des données complètes et incomplètes pour cet utilisateur
        $fields = ['telephone', 'adresse', 'dateNaissance']; // Ajustez selon votre modèle
        $completionData = [
            'complete' => 0,
            'incomplete' => 0
        ];
        
        foreach ($fields as $field) {
            $getter = 'get' . ucfirst($field);
            if (method_exists($user, $getter) && !empty($user->$getter())) {
                $completionData['complete']++;
            } else {
                $completionData['incomplete']++;
            }
        }
        
        // Calcul des statistiques globales pour tous les utilisateurs
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $globalStats = [];
        
        foreach ($fields as $field) {
            $globalStats[$field] = 0;
            $getter = 'get' . ucfirst($field);
            
            foreach ($users as $u) {
                if (method_exists($u, $getter) && empty($u->$getter())) {
                    $globalStats[$field]++;
                }
            }
        }
        
        return $this->render('admin/donnee.html.twig', [
            'user' => $user,
            'completionData' => $completionData,
            'globalStats' => $globalStats
        ]);
    }
}