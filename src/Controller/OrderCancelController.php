<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderCancelController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/erreur/{stripeSessionId}", name="order_cancel")
     */
    public function index($stripeSessionId, CategoryRepository $category)
    {
        $categories = $category->findAll();
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {  /* Si la commande n'existe pas je renvoi vers la home OU regarder si le $order->getUser est bien égale à l'utilisateur que je suis moi en ce moment (connecté) */
            return $this->redirectToRoute('home');
        }

        // Envoyer un email à notre utilisateur pour lui indiquer l'échec de paiement

        return $this->render('order_cancel/index.html.twig', [
            'order' => $order,
            'categories' => $categories,
        ]);
    }
}
