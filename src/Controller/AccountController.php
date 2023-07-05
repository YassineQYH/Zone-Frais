<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/compte", name="account")
     */
    public function index(CategoryRepository $category, Cart $panier): Response
    {
        $panier=$panier->getFull();

        $categories = $category->findAll();
        
        return $this->render('account/index.html.twig', [
            'categories' => $categories,
            'panier' => $panier
        ]);
    }
}
