<?php

namespace App\Controller\Admin;

use App\Entity\Orders;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrdersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Orders::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', "ID:"),
            MoneyField::new('total', "Coût Total:")->setCurrency('EUR'),
            BooleanField::new('pending', "En Attente:"),
            BooleanField::new('payed', "Payée:"),
            BooleanField::new('fail', "Echouée:"),
            AssociationField::new('user', "Commandé par:"),
            DateTimeField::new('created_at', "Ajouté le:")->hideOnForm(),
            DateTimeField::new('updated_at', "Modifié le:")->hideOnForm(),
        ];
    }
    
}
