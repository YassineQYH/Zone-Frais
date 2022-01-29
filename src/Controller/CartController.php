<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use App\Entity\Weight;
use App\Repository\CategoryRepository;
use App\Repository\WeightRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Cast\Double;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart, CategoryRepository $category, WeightRepository $weight)
    {
        

        (double) $poid = $qtty = null ;
        $categories = $category->findAll();

        $cart=$cart->getFull();
        foreach($cart as $element){
            $poidAndQtty=$element['product']->getWeight()->getKg() * $element['quantity'];
            $qtty+=$element['quantity'];
            $poid+=$poidAndQtty;
        }

        $priceList=$this->fillPriceList($weight);
        $totalLivraison=$priceList[$poid];

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'categories' => $categories,
            'poid' => $poid,
            'qtty' => $qtty,
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

    /**
     * @Route("/cart/add/{id}", name="add_to_cart" , methods={"GET","POST"})
     */
    public function add(Cart $cart, $id,Product $product ,Request $request)
    {   
        //dd($request->request);
        // $notification = 'Votre produit à bien été ajouté au panier';
        $cart->add($id);
        
        // return $this->redirectToRoute('cart');
        //dd($_SERVER['HTTP_REFERER']);
        //return $this->redirectToRoute('add_to_cart', ['id' => 17 ]);
        return $this->redirect($_SERVER['HTTP_REFERER']);

//return $this->redirectToRoute(['add_to_cart' : ]);
        // return $notification;
    }

    /**
     * @Route("/cart/remove", name="remove_my_cart")
     */
    public function remove(Cart $cart)
    {
        $cart->remove();
        return $this->redirectToRoute('products');
    }

    /**
     * @Route("/cart/delete/{id}", name="delete_to_cart")
     */
    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * @Route("/cart/decrease/{id}", name="decrease_to_cart")
     */
    public function decrease(Cart $cart, $id)
    {
        $cart->decrease($id);

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    /**
     * @Route("/cart/increase/{id}", name="increase_to_cart")
     */
    public function increase(Cart $cart, $id)
    {
        $cart->add($id);

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
