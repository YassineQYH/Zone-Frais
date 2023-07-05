<?php

namespace App\Controller;

use App\Entity\Order;
use App\Classe\Cart;
use App\Repository\WeightRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountOrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/compte/mes-commandes", name="account_order")
     */
    public function index(Cart $panier, CategoryRepository $category, WeightRepository $weight)
    {
        $panier=$panier->getFull();
        
        $categories = $category->findAll();

        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getUser());

        (double) $poid = $totalLivraison = $quantity_product = null ;
        (double) $price = $totalPrixLivraison = $quantity_product = null ;

        foreach($panier as $element){
            $poidAndQantity=$element['product']->getWeight()->getKg() * $element['quantity'];
            $quantity_product+=$element['quantity'];
            $poid+=$poidAndQantity;
        }

        $prix=$weight->findByKgPrice($poid)->getPrice();

        return $this->render('account/order.html.twig', [
            'orders' => $orders,
            'categories' => $categories,
            'poid' => $poid,
            'price' => $prix,
            'quantity_product' => $quantity_product,
            'panier' => $panier
        ]);
    }

    /**
     * @Route("/compte/mes-commandes/{reference}", name="account_order_show")
     */
    public function show($reference, CategoryRepository $category, WeightRepository $weight, Cart $cart)
    {
        $categories = $category->findAll();
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        (double) $poid = $totalLivraison = $quantity_product = null ;
        (double) $price = $totalPrixLivraison = $quantity_product = null ;
        

        $cart=$cart->getFull();

        foreach($cart as $element){
            $poidAndQantity=$element['product']->getWeight()->getKg() * $element['quantity'];
            $quantity_product+=$element['quantity'];
            $poid+=$poidAndQantity;
        }

        $prix=$weight->findByKgPrice($poid)->getPrice();
        

        if(!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_order');
        }

        return $this->render('account/order_show.html.twig', [
            'order' => $order,
            'categories' => $categories,
            'quantity_product' => $quantity_product,
            'poid' => $poid,
            'price' => $prix,
            'totalLivraison' => $totalLivraison ?: null,
            'cart' => $cart
        ]);
    }
    
    public function fillPriceList($weight){
        $priceList=[];
        $weight = $weight->findAll();

        foreach($weight as $item){
           $priceList[(string) $item->getKg()]=$item->getPrice();
        }  

        return $priceList;         
         //dd( (double) ($priceList["0.75"]));
    }

}
