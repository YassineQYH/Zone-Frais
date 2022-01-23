<?php

namespace App\Controller;


use App\Entity\Product;
use App\Entity\Illustration;
use App\Entity\Category;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryAccessoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager,ProductRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    
    /**
    * @Route("/nos-produits", name="produits")
    */
    public function index(Request $request, CategoryRepository $category, PaginatorInterface $paginator)
    {
        $articles = $this->entityManager->getRepository(Product::class)->findAll();
            $products = $paginator->paginate(
                $articles,
                $request->query->getInt('page', 1),
                9
            );
        $categories = $category->findAll();

        return $this->render('produits/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }


    /**
    * @Route("/produit/{slug}", name="produit")
    */
    public function show($slug, Product $product, CategoryRepository $category)
    {
        $categories = $category->findAll();
        $categoryProduits = $this->entityManager->getRepository(Category::class)->findAll();

        $illustrations = $this->entityManager->getRepository(Illustration::class)->findByProduct($product);

        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);

        if (!$product){
            return $this->redirectToRoute('products');
        }

        return $this->render('produits/show.html.twig', [
            'product' => $product,
            'illustrations' => $illustrations,
            'categories' => $categories,
            'categoryProduits' => $categoryProduits,
        ]);
    }

    /**
    * @Route("/nos-produits/categorie-{categoryProduit}", name="categorie")
    */
    public function choixCategory(Category $categoryProduit, CategoryRepository $category, PaginatorInterface $paginator, Request $request,)
    {

        {
            $articles = $this->entityManager->getRepository(Product::class)->findAllOrderByCategory($categoryProduit);
            $products = $paginator->paginate(
                $articles,
                $request->query->getInt('page', 1),
                6
            );
        }
        $categories = $category->findAll();

        return $this->render('produits/category.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
