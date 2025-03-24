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


class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id')->onlyOnIndex()	,
            ArrayField::new('roles')->hideOnForm(),
            TextField::new('password')->onlyOnForms()->hideOnForm(), // Pour ne pas afficher le mot de passe en clair
            TextField::new('Nom'),
            TextField::new('prenom'),
            BooleanField::new('isVerified')->hideOnForm(),
            UrlField::new('pdf', 'PDF')
            ->onlyOnIndex()
            ->setLabel('PDF')
            ->setCustomOption('renderAsButton', true)
            ->setCustomOption('buttonLabel', '<i class="fa fa-file-pdf"></i> Générer PDF')
            ->formatValue(function ($value, $entity) {
                return '/admin/generer-pdf/' . $entity->getId();
            }),
        ];
    }
}