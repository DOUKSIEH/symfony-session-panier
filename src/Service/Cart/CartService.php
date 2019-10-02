<?php

namespace App\Service\Cart;


use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {
   
    protected $productRepository;
    protected $session;

   public  function __construct(ProductRepository $productRepository, SessionInterface $session)
   {
        $this->productRepository = $productRepository;
        $this->session = $session;
   }
   /**
    * Permet d'ajouter un panier
    *
    * @param integer $id
    * @return void
    */
    public function add(int $id){

          // $session = $request->getSession();

          $panier = $this->session->get('panier', []);

          //$panier[$id] = 0;
  
          if(empty($panier[$id]))
          {
  
              $panier[$id] = 1;
          }
          else
          {
              $panier[$id]++;
  
          }
          // if(empty($panier[$id])){
  
          //     $panier[$id] = 1;
          // }
          // $panier[$id]++;
          $this->session->set('panier',$panier);

          //dd($this->session->get('panier'));

    }
    /**
     * Permet de supprimer un panier
     *
     * @param integer $id
     * @return void
     */
    public function remove(int $id){

        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id]))
        {

            unset($panier[$id]);
        }

        $this->session->set('panier',$panier);
        
    }
    /**
     * Permet d'obtenir le contenu du panier
     *
     * @return array
     */
    public function getFullCart() : array{
       
        $panier = $this->session->get('panier', []);

        $panierWithData = [];
   
        foreach ($panier as $id => $quantity) {
            $panierWithData [] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }
      return $panierWithData;
    }
    /**
     * Permet de calcul le total dans un panier
     *
     * @return integer
     */
    public function getTotal() : float {

        $total = 0;
        
        foreach ($this->getFullCart() as $item) {

          $total += $item["product"]->getPrice() * $item["quantity"] ;
            # code...
        }

        return $total;

    }

}
