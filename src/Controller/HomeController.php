<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Header;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\ContactType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, CategoryRepository $category, Cart $cart)
    {        
        $cart=$cart->getFull();

        $form = $this->createForm(ContactType::class);
        
        $headers = $this->entityManager->getRepository(Header::class)->findAll();

        $categories = $category->findAll();

        $categorys = $this->entityManager->getRepository(Category::class)->findAll();

        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', "Merci de m'avoir contacté. Je vous répondrais dans les meilleurs délais.");

            /* dd($form->getData()); */
            $content = "Bonjour </br>
                        Vous avez reçus un message depuis Pergolazur. </br>
                        De l'utilisateur : <strong>".$form->getData()['name']."</strong></br>
                        De la société : <strong>".$form->getData()['company']."</strong></br>
                        N° de tel : <strong>".$form->getData()['tel']."</strong></br>
                        Adresse email : <strong style='color:black;'>".$form->getData()['email']."</strong> </br>
                        Message : ".$form->getData()['message']."</br></br>";

            $mail = new Mail();
            $mail->send('yassine.qyh@gmail.com', 'Pergolazur', 'Vous avez reçus une nouvelle demande de contact', $content);
        }
        
        return $this->render('home/index.html.twig', [
            'headers' => $headers,
            'categories' => $categories,
            'products' => $products,
            'categorys' => $categorys,
            'form' => $form->createView(),
            'cart' => $cart,
        ]);
    }
}
