<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Carrier;
use App\Entity\Header;
use App\Entity\TodoList;
use App\Entity\Inspiration;
use App\Entity\ItemCategory;
use App\Entity\InspirationCategory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(TodoListCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dydream Decor');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToCrud('Todo list', 'fas fa-clipboard-list', TodoList::class);
        yield MenuItem::linkToCrud('Clients', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Articles', 'fas fa-tag', Item::class);
        yield MenuItem::linkToCrud('Catégories d\'articles', 'fas fa-boxes', ItemCategory::class);
        yield MenuItem::linkToCrud('Inspirations', 'fas fa-birthday-cake', Inspiration::class);
        yield MenuItem::linkToCrud('Catégories d\'inspirations', 'fas fa-window-restore', InspirationCategory::class);
        yield MenuItem::linkToCrud('Transporteurs', 'fas fa-truck', Carrier::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Entêtes', 'fas fa-pager', Header::class);
    }
}