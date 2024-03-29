<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use App\Entity\Product;
use App\Repository\CategoryRepository;
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

    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index(Cart $panier, $stripeSessionId, CategoryRepository $category)
    {

        /* Gestion automatique du stock */
        foreach ($panier->getFull() as $element) {

            $id=$element['product']->getId();
            $repo = $this->entityManager->getRepository(Product::class)->findBy(['id' => $id]);
            $getProductStockById = $repo[0]->getStock();

            $getProductQtyCart =$element['quantity'];
            $result = $getProductStockById - $getProductQtyCart;
            $dql = "update App\Entity\Product p SET p.stock='{$result}'  WHERE p.id = '{$id}'";
            $query =  $this->entityManager->createQuery($dql);
            $query->execute();
        }   

        $categories = $category->findAll();
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {  /* Si la commande n'existe pas je renvoi vers la home OU regarder si le $order->getUser est bien égale à l'utilisateur que je suis moi en ce moment (connecté) */
            return $this->redirectToRoute('home');
        }

        if ($order->getState() == 0 ) {
            // Vider la session "cart" après le paiement
            $panier->remove();

            // Modifier le statut isPaid de notre commande en mettant 1
            $order->setState(1);
            $this->entityManager->flush();

            // Envoyer un email à notre client pour lui confirmer sa commande
            $mail = new Mail();
            $content = "Bonjour ".$order->getUser()->getFirstname()."</br>SY-Shop vous remercie pour votre commande n°<strong>" .$order->getReference()."</strong> pour un total de " .$order->getTotal()/100 ." Euros.</br>Vous serez averti lorsque la préparation de la commande sera terminée et envoyée.</br>";
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), "Votre commande n° ".$order->getReference()." est bien validée.Vous serez averti par mail lors de la préparation de votre commande et aussi lors de l'envoi de votre commande.", $content);

            // Envoyer un email à l'admin pour l'informer qu'une commande à été passé.
            $mail = new Mail();
            $subject = "Une nouvelle commande vient d'être validée et payée.";
            $content = "Bonjour, </Br>La commande n°<strong>" .$order->getReference()."</strong> de <strong>".$order->getUser()->getFirstname()." ".$order->getUser()->getLastname(). "</strong> vient d'être payée et validée.
            ";
            $mail->send('admin@sy-shop.yassine-qayouh-dev.com', '', '', $content);
        }



        return $this->render('order_success/index.html.twig', [
            'order' => $order,
            'categories' => $categories,
            'panier' => $panier,
        ]);
    }
}
