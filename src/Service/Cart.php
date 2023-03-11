<?php

namespace App\Service;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $entityManager;
    private $session;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
    }

   public function getWholeCart() 
   {
        $wholeCart =[];

        if ($this->get()){
            foreach ($this->get() as $id => $quantity) {
                $item_object = $this->entityManager->getRepository(Item::class)->find($id);
                
                if ($item_object){
                    $wholeCart[] = [
                        'item' => $item_object,
                        'quantity' => $quantity
                    ];  
                }    
            }
        }
        return $wholeCart;
    }

    public function add($id)
    {
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])){
            $cart[$id]++;
        }else {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function delete($id)
    {
        $cart = $this->session->get('cart', []);

        unset($cart[$id]);

        return $this->session->set('cart', $cart);
    }

    public function minusOne($id)
    {
        $cart = $this->session->get('cart', []);

        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        return $this->session->set('cart', $cart);
    }

    public function clear()
    {
        return $this->session->clear('cart');
    }
}