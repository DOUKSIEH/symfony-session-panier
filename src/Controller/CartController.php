<?php

namespace App\Controller;


use App\Service\Cart\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cart)
    {
       
              
        return $this->render('cart/index.html.twig', [
            'items' => $cart->getFullCart(),
            'total'=> $cart->getTotal()
        ]);
    }
    /**
     * @Route("/panier/add/{id}", name = "card_add")
    */
    public function add(int $id, CartService $cart){


       $cart->add($id);
        
       return $this->redirectToRoute("cart_index");


    }
    /**
     * @Route("/panier/remove/{id}",name="cart_remove")
     */
    public function remove(int $id, CartService $cart){

        $cart->remove($id);
        
        return $this->redirectToRoute("cart_index");

    }
}
