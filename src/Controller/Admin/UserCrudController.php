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
        $generateDocxAction = Action::new('generateDocx', 'Générer DOCX')
            ->linkToUrl(function (User $user) {
                $infoEleve = $user->getInfoEleve();
                return $infoEleve ? $this->adminUrlGenerator
                    ->setRoute('generer_docx', ['id' => $infoEleve->getId()])
                    ->generateUrl() : '#';
            });

        return $actions
            ->add(Crud::PAGE_INDEX, $generateDocxAction)
            ->add(Crud::PAGE_DETAIL, $generateDocxAction);
    }
}