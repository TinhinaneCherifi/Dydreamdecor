<?php

namespace App\Controller;

use App\Entity\Order;
use App\Service\Cart;
use App\Service\MailJet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/succes-paiement/{stripeSessionId}', name: 'order_success')]
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        $user = $order->getUser(); //ajouté pour l'envoi de mail
        
        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($order->getStatus() == 0){
            $order->setStatus(1);
            $this->entityManager->flush();
            $cart->clear();
            
            // send an email
            $mailJet = new MailJet();
            $subject = 'Commande validée';
            $title = 'Merci pour votre commande';
            $content = 'Cher(e)'.$order->getUser()->getFirstname().', merci de nous avoir fait confiance. Votre commande est en cours de préparation.';
            $button = 'Suivre ma commande';
            $mailJet->send($user->getEmail(),$user->getFirstname(), $subject, $title, $content, $button);
        }
        
        return $this->render('payment_success/index.html.twig',[
            'order' => $order
        ]);
    }
}
