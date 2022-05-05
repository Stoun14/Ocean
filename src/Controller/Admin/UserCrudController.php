<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', "ID:")->hideOnForm()->hideOnIndex(),
            EmailField::new('email', "Email:"),
            ChoiceField::new('roles', "Rôles:")->setChoices([
                'Utilisateur' => 'ROLE_USER',
                'Editeur' => 'ROLE_EDITOR',
                'Administrateur' => 'ROLE_ADMIN',
            ])->allowMultipleChoices(),
            TextField::new('password', "Mot de passe")->hideOnIndex()->setFormTypeOptions([
                'help' => '8 caractères minimum',
                'attr' => [
                    'minLength' => 8
                    ]
                ]),
            TextField::new('firstname', "Prénom:"),
            TextField::new('lastname', "Nom:"),
            TextField::new('address', "Adresse:"),
            TextField::new('zip', "Code Postal:"),
            TextField::new('city', "Ville:"),
            TelephoneField::new('phone_number', "Numéro de Téléphone:"),
            BooleanField::new('isVerified', "Email Vérifié"),
            
        ];
    }
}
