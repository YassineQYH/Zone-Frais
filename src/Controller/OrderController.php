<?php

namespace App\Controller;

use DateTime;
use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Weight;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use App\Repository\WeightRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class OrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande", name="order")
     */
    public function index(Cart $panier, Request $request, CategoryRepository $category)
    {
        $categories = $category->findAll();

        if (!$this->getUser()->getAddresses()->getValues())
        {
            return $this->redirectToRoute('account_address_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser() /* Me permettra de récupérer dans mon formulaire l'utilisateur en question pour récupérer ses adresses à lui et pas aussi celles des autres utilisateurs. | Voir ensuite OrderType.php */
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'panier' => $panier->getFull(),
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/commande/recapitulatif", name="order_recap", methods={"POST"})
     */
    public function add(Cart $cart, Request $request, WeightRepository $weight, CategoryRepository $category)   /* methods={"POST"} => accepter uniquement ceux qui viennent d'un POST */
    {
        $categories = $category->findAll();

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser() /* Me permettra de récupérer dans mon formulaire l'utilisateur en question pour récupérer ses adresses à lui et pas aussi celles des autres utilisateurs. | Voir ensuite OrderType.php */
        ]);

        (double) $poid = $qantity_product = null ;

        $panier=$cart->getFull();
        foreach($panier as $element){
            $poidAndQantity=$element['product']->getWeight()->getKg() * $element['quantity'];
            $qantity_product+=$element['quantity'];

            $poid+=$poidAndQantity;
        }

        $prix=$weight->findByKgPrice($poid)->getPrice();

        $priceList=$this->fillPriceList($weight);

            $form->handleRequest($request); /* Pour dire au formulaire : écoute la requête s'il te plait. */

            if ($form->isSubmitted() && $form->isValid()) {
                //dd($form->getData());
                
                $date = new DateTime();
                /* $carriers = $form->get('carriers')->getData(); */
                $delivery = $form->get('addresses')->getData();
                $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname();
                $delivery_content .= '</br>'.$delivery->getPhone();
                
                if ($delivery->getCompany()) {
                    $delivery_content .= '</br>'.$delivery->getCompany();
                }
                
                $delivery_content .= '</br>'.$delivery->getAddress();
                $delivery_content .= '</br>'.$delivery->getPostal().' '.$delivery->getCity();
                $delivery_content .= '</br>'.$delivery->getCountry();

                // Enregistrer ma commande Order()
                    $order = new Order();
                    $reference = $date->format('dmY').'-'.uniqid();
                    $order->setReference($reference);
                    $order->setUser($this->getUser());
                    $order->setCreatedAt($date);
                    $order->setCarrierPrice($prix);
                    $order->setDelivery($delivery_content);
                    $order->SetState(0);

                    $this->entityManager->persist($order);

                    /* dd($cart->getFull()); */
                // Enregistrer mes produits OrderDetails()
                foreach ($cart->getFull() as $element) {
                    $orderDetails = new OrderDetails();
                    $orderDetails->setMyOrder($order);
                    $orderDetails->setProduct($element['product']->getName());
                    $orderDetails->setWeight($element['product']->getWeight());
                    $orderDetails->setQuantity($element['quantity']);
                    $orderDetails->setPrice($element['product']->getPrice());
                    $orderDetails->setTotal($element['product']->getPrice() * $element['quantity']);
                    
                    $this->entityManager->persist($orderDetails);
                }   

                $this->entityManager->flush();

                return $this->render('order/add.html.twig', [
                    'cart' => $cart->getFull(),
                    /* 'carrier' => $carriers, */
                    'delivery' => $delivery_content,
                    'reference' => $order->getReference(),
                    'price' => $prix,
                    'totalLivraison' =>  null,
                    'categories' => $categories
                ]);
            }

        return $this->redirectToRoute('cart');
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
