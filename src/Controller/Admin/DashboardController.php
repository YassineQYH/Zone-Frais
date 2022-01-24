<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Header;
use App\Entity\Illustration;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\Weight;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
            return parent::index();

            /* $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

            return $this->redirect($routeBuilder->setController(OrderCrudController::class)->generateUrl()); */


            /* $routeBuilder = $this->get(AdminUrlGenerator::class);

            return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl()); */
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Zone-Frais');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Orders', 'fa fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Bannière', 'fas fa-desktop', Header::class);
        yield MenuItem::linkToCrud('Produit', 'fas fa-home', Product::class);
        yield MenuItem::linkToCrud('Poids', 'fas fa-home', Weight::class);
        yield MenuItem::linkToCrud('Illustration', 'fas fa-home', Illustration::class);
        yield MenuItem::linkToCrud('Catégorie', 'fas fa-home', Category::class);
        yield MenuItem::linkToCrud('Carriers', 'fa fa-truck', Carrier::class);

    }
}
