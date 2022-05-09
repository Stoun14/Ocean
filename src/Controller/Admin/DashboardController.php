<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Orders;
use App\Entity\Article;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(ArticleCrudController::class)->generateUrl();

        return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ocean');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute("Retour à l'accueil", 'fas fa-home', 'home');
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::subMenu('Articles', 'fas fa-newspaper')->setSubItems([            
            MenuItem::linkToCrud('Afficher les articles', 'fas fa-eye', Article::class),
            MenuItem::linkToCrud('Créer un article', 'fas fa-plus', Article::class)->setAction(Crud::PAGE_NEW)
        ]);
        yield MenuItem::subMenu('Commandes', 'fas fa-list')->setSubItems([            
            MenuItem::linkToCrud('Afficher les Commandes', 'fas fa-eye', Orders::class),
            MenuItem::linkToCrud('Créer une Commande', 'fas fa-plus', Orders::class)->setAction(Crud::PAGE_NEW)
        ]);
        yield MenuItem::subMenu('Produits', 'fas fa-tags')->setSubItems([            
            MenuItem::linkToCrud('Afficher les produits', 'fas fa-eye', Products::class),
            MenuItem::linkToCrud('Créer un produit', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)
        ]);
        yield MenuItem::subMenu('Utilisateurs', 'fas fa-user')->setSubItems([            
            MenuItem::linkToCrud('Afficher les utilisateurs', 'fas fa-eye', User::class),
            MenuItem::linkToCrud('Créer un utilisateur', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW)
        ]);
    }
}
