<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public const ARTICLE_BASE_PATH = "/images/articles";
    public const ARTICLE_UPLOAD_DIR = "public/images/articles";

    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $article = new Article();
        $article->setUser($this->getUser());

        return $article;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', "ID:")->hideOnForm(),
            TextField::new('title', "Titre:"),
            TextField::new('header', "Chapô:"),
            ImageField::new('image', "Illustration:")
                ->setBasePath(self::ARTICLE_BASE_PATH)
                ->setUploadDir(self::ARTICLE_UPLOAD_DIR)
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            TextareaField::new('content', "Corps de l'article:"),
            DateTimeField::new('created_at', "Ajouté le:")->hideOnForm(),
            DateTimeField::new('updated_at', "Modifié le:")->hideOnForm(),
        ];
    }
}
