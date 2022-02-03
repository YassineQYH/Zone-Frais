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
    public function index(Cart $cart, CategoryRepository $category, WeightRepository $weight)
    {
        
        $categories = $category->findAll();

        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getUser());

        (double) $poid = $qantity_product = null ;

        $cart=$cart->getFull();
        foreach($cart as $element){
            $poidAndQantity=$element['product']->getWeight()->getKg() * $element['quantity'];
            $qantity_product+=$element['quantity'];
            $poid+=$poidAndQantity;
        }

        $prix=$weight->findByKgPrice($poid)->getPrice();
        $priceList=$this->fillPriceList($weight);
        /* $totalLivraison=$priceList[$poid]; */

        return $this->render('account/order.html.twig', [
            'orders' => $orders,
            'categories' => $categories,
            'price' => $prix/* ,
            'totalLivraison' => $totalLivraison */
        ]);
    }

    /**
     * @Route("/compte/mes-commandes/{reference}", name="account_order_show")
     */
    public function show($reference, CategoryRepository $category, WeightRepository $weight)
    {
        $categories = $category->findAll();
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        (double) $poid = $qantity_product = null ;

        $cart=$cart->getFull();
        foreach($cart as $element){
            $poidAndQantity=$element['product']->getWeight()->getKg() * $element['quantity'];
            $qantity_product+=$element['quantity'];
            $poid+=$poidAndQantity;
        }

        $priceList=$this->fillPriceList($weight);
        $totalLivraison=$priceList[$poid];

        if(!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_order');
        }

        return $this->render('account/order_show.html.twig', [
            'order' => $order,
            'categories' => $categories,
            'totalLivraison' => $totalLivraison
        ]);
    }
    
    public function fillPriceList($weight){
        $priceList=[];
        $weight = $weight->findAll();

        foreach($weight as $item){
           // $priceList[$item->getKg()]=$item->getPrice();
           $priceList[(string) $item->getKg()]=((string) $item->getPrice());
        }  
        return $priceList;         
         //dd( (double) ($priceList["0.75"]));
    }

}
