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
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;


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
            IdField::new('id')->onlyOnIndex(),
            ArrayField::new('email')->hideOnForm(),
            TextField::new('password')->onlyOnForms()->hideOnForm(), // Pour ne pas afficher le mot de passe en clair
            TextField::new('Nom'),
            TextField::new('prenom'),
            BooleanField::new('isVerified')->hideOnForm(),
            // Field::new('pdf', 'Générer PDF')
            //     ->onlyOnIndex()
            //     ->formatValue(function ($value, $entity) {
            //         return sprintf(
            //             '<a class="btn btn-success" href="%s" target="_blank">
            //                 <i class="fas fa-file-pdf"></i> Télécharger PDF
            //             </a>',
            //             '/admin/generer-docx/' . $entity->getId()
            //         );
            //     }),
        ];
    }
}