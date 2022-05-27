<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public const PRODUCT_BASE_PATH = "images/products";
    public const PRODUCT_UPLOAD_DIR = "public/images/products";

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', "ID:")->hideOnForm(),
            TextField::new('name', "Intitulé:"),
            AssociationField::new('category', "Catégorie:"),
            ImageField::new('image', "Image:")
                ->setBasePath(self::PRODUCT_BASE_PATH)
                ->setUploadDir(self::PRODUCT_UPLOAD_DIR)
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            TextareaField::new('description', 'Description:'),
            MoneyField::new('price', "Prix:")->setCurrency('EUR'),
            DateTimeField::new('created_at', "Ajouté le:")->hideOnForm(),
            DateTimeField::new('updated_at', "Modifié le:")->hideOnForm()
        ];
    }
}
