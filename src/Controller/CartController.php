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

use function PHPSTORM_META\type;

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
        $categories = $category->findAll();

        $weight_negatif=[];
        (double) $poid = $totalLivraison = $quantity_product = null ;
        (double) $price = $totalPrixLivraison = $quantity_product = null ;

        $cart=$cart->getFull();

        foreach($cart as $element){
            $poidAndQantity=$element['product']->getWeight()->getKg() * $element['quantity'];
            $quantity_product+=$element['quantity'];
            $poid+=$poidAndQantity;
        }

        $prix=$weight->findByKgPrice($poid)->getPrice();

        /* dd($prix); */

        //$execpt=["0.25","0.5","0.75"];

        /* for($i=0.01;$i<=0.99;$i++){
            $weight_negatif[]=$i;
        } */
        for($x = 0.01; $x < 1; $x = $x +0.01){
            $weight_negatif[]=$x;
        }
        //dd($weight_negatif);
        

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'categories' => $categories,
            'poid' => $poid,
            'price' => $prix,
            'quantity_product' => $quantity_product,
            'totalLivraison' => $totalLivraison ?: null
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

    /**
     * @Route("/cart/add/{id}", name="add_to_cart" , methods={"GET","POST"})
     */
    public function add(Cart $panier, $id,Product $product ,Request $request)
    {   
        //dd($request->request);
        // $notification = 'Votre produit à bien été ajouté au panier';
        $panier->add($id);
        
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
    public function remove(Cart $panier)
    {
        $panier->remove();
        return $this->redirectToRoute('products');
    }

    /**
     * @Route("/cart/delete/{id}", name="delete_to_cart")
     */
    public function delete(Cart $panier, $id)
    {
        $panier->delete($id);

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * @Route("/cart/decrease/{id}", name="decrease_to_cart")
     */
    public function decrease(Cart $panier, $id)
    {
        $panier->decrease($id);

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    /**
     * @Route("/cart/increase/{id}", name="increase_to_cart")
     */
    public function increase(Cart $panier, $id)
    {
        $panier->add($id);

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
