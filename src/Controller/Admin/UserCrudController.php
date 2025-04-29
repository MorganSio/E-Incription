<?php
namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class UserCrudController extends AbstractCrudController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new(propertyName: 'id')->onlyOnIndex()	,
            ArrayField::new('roles')->hideOnForm(),
            TextField::new('password')->onlyOnForms()->hideOnForm(), // Pour ne pas afficher le mot de passe en clair
            TextField::new('Nom'),
            TextField::new('prenom'),
            BooleanField::new('isVerified')->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);

        return $actions
            ->add(Crud::PAGE_INDEX, $this->createGenerateDocxAction('generateDocxIntendance', 'Générer PDF Intendance', 'generer_docx_intendance'))
            ->add(Crud::PAGE_DETAIL, $this->createGenerateDocxAction('generateDocxIntendance', 'Générer PDF Intendance', 'generer_docx_intendance'))

            ->add(Crud::PAGE_INDEX, $this->createGenerateDocxAction('generateDocxUrgence', 'Générer PDF Urgence', 'generer_docx_urgence'))
            ->add(Crud::PAGE_DETAIL, $this->createGenerateDocxAction('generateDocxUrgence', 'Générer PDF Urgence', 'generer_docx_urgence'))

            ->add(Crud::PAGE_INDEX, $this->createGenerateDocxAction('generateDocxMdl', 'Générer PDF Mdl', 'generer_docx_mdl'))
            ->add(Crud::PAGE_DETAIL, $this->createGenerateDocxAction('generateDocxMdl', 'Générer PDF Mdl', 'generer_docx_mdl'))

            ->add(Crud::PAGE_INDEX, $this->createGenerateDocxAction('generateDocxDossier', 'Générer PDF Dossier', 'generer_docx_dossier'))
            ->add(Crud::PAGE_DETAIL, $this->createGenerateDocxAction('generateDocxDossier', 'Générer PDF Dossier', 'generer_docx_dossier'));
    }

    private function createGenerateDocxAction(string $actionName, string $label, string $route): Action
    {
        return Action::new($actionName, $label)
            ->linkToUrl(function (User $user) use ($route) {
                $infoEleve = $user->getInfoEleve();
                if (!$infoEleve) {
                    return '#';
                }
                return $this->adminUrlGenerator
                    ->setRoute($route, ['id' => $infoEleve->getId()])
                    ->generateUrl();
            });
    }
}