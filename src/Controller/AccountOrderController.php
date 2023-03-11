<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountOrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/commandes', name: 'account_order_index')]
    public function index(): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findPaidOrders($this->getUser());
        
        return $this->render('account/order_index.html.twig', [
            'orders' => $orders
        ]);
    }


    #[Route('/compte/commandes/{ref}', name: 'account_order_show')]
    public function show($ref): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByRef($ref);
        
        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_order_index');
        }
        
        return $this->render('account/order_show.html.twig', [
            'order' => $order
        ]);
    }
}
