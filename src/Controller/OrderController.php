<?php

namespace App\Controller;

use App\Entity\Order;
use App\Service\Cart;
use DateTimeImmutable;
use App\Form\OrderType;
use App\Entity\OrderDetail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande', name: 'order')]
    public function index(Cart $cart, Request $request): Response
    {
        if (!$this->getUser()->getAddresses()->getValues())
        {
            return $this->redirectToRoute('account_address_add');
        }
        $form = $this->createForm(OrderType::class, null, [
            'user' =>$this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getWholeCart()
        ]);
    }
    
    #[Route('/commande/recapitulatif', name: 'order_summary', methods: 'POST')]
    public function add(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user' =>$this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTimeImmutable();
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('addresses')->getData();
            $deliveryContent = $delivery->getFirstname().' '.$delivery->getLastname();
            $deliveryContent .= '<br/>'.$delivery->getPhone();
            
            if($delivery->getCompany())
            {
                $deliveryContent .= '<br/>'.$delivery->getCompany();
            }

            $deliveryContent .= '<br/>'.$delivery->getAddress();
            $deliveryContent .= '<br/>'.$delivery->getZip().' '.$delivery->getCity();
            $deliveryContent .= '<br/>'.$delivery->getCountry();

    
            $order = new Order();
            $ref = $date->format('Ymd').'-'.uniqid();
            $order->setRef($ref);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDeliveryAddress($deliveryContent);
            $order->setStatus(0);

            $this->entityManager->persist($order);

            foreach($cart->getWholeCart() as $item){
                $orderDetail = new OrderDetail();
                $orderDetail->setDetailedOrder($order);
                $orderDetail->setItem($item['item']->getName());
                $orderDetail->setQuantity($item['quantity']);
                $orderDetail->setPrice($item['item']->getPrice());
                $orderDetail->setTotal($item['item']->getPrice() * $item['quantity']);
                
                $this->entityManager->persist($orderDetail); 
            }
    
            $this->entityManager->flush();

            return $this->render('order/add.html.twig', [
                'cart' => $cart->getWholeCart(),
                'carriers'=> $carriers,
                'delivery' => $deliveryContent,
                'ref' => $order->getRef()
            ]);
        }    
        return $this->redirectToRoute('cart');   
    }
}
