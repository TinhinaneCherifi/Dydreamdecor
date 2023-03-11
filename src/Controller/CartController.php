<?php

namespace App\Controller;

use App\Entity\Item;
use App\Service\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/panier', name: 'cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig',[
            'cart' => $cart->getWholeCart()
        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/delete/{id}', name: 'delete_from_cart')]
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/minus-one/{id}', name: 'minus_one')]
    public function minusOne(Cart $cart, $id): Response
    {
        $cart->minusOne($id);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/clear', name: 'clear_cart')]
    public function clear(Cart $cart): Response
    {
        $cart->clear();

        return $this->redirectToRoute('items');
    }
}
