<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Item;
use App\Entity\Order;
use App\Service\Cart;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    #[Route('/commande/create-session/{ref}', name: 'stripe_create_session')]
    public function index(EntityManagerInterface $entityManager, Cart $cart, $ref): Response
    {
        $stripeItems = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        $order = $entityManager->getRepository(Order::class)->findOneByRef($ref);
        
        if (!$order) {
            new JsonResponse(['error' => 'order']);
        }
        
        foreach($order->getOrderDetails()->getValues() as $item) {
            $item_object = $entityManager->getRepository(Item::class)->findOneByName($item->getItem());
            $stripeItems[] = [
                'price_data' => [
                    'currency' =>'eur',
                    'unit_amount' => $item->getPrice(),
                    'product_data' => [
                        'name' => $item->getItem(),
                        'images' => [$YOUR_DOMAIN."/uploads/item_images/".$item_object->getImage()]
                    ]
                ],
                'quantity' => $item->getQuantity()
            ];
        }

        $stripeItems[] = [
            'price_data' => [
                'currency' =>'eur',
                'unit_amount' => $order->getCarrierPrice(),
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$YOUR_DOMAIN]
                ]
            ],
            'quantity' => 1
        ];

        Stripe::setApiKey('sk_test_51KciR1APCZ8zVzFHE0DGh6c3pT7tC7LnkkQ1hc61JhFK59JFQGJK23CtRpc1KzVuCB7bi29Y0pXVVWqcCvLyhi9200wrDFGcS3');

            $checkout_session = Session::create([
                'customer_email' => $this->getUser()->getEmail(),              
                'payment_method_types' => ['card'],
                'line_items' => [$stripeItems],
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/commande/succes-paiement/{CHECKOUT_SESSION_ID}',
                'cancel_url' => $YOUR_DOMAIN . '/commande/echec-paiement/{CHECKOUT_SESSION_ID}'
            ]);
            
            $order->setStripeSessionId($checkout_session->id);
            $entityManager->flush();

            $response = new JsonResponse(['id' => $checkout_session->id]);
            return $response;
    }
}
