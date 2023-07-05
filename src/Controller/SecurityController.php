<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Category;
use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager,ProductRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }


    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(Request $request, CategoryRepository $category, AuthenticationUtils $authenticationUtils, UserPasswordEncoderInterface $encoder, Cart $panier): Response
    {
        /* Pour afficher les infos dans le widget panier */
        $panier=$panier->getFull();

        /* Pour la nav */
        $categories = $category->findAll();
        
        /* Login */
        /* if ($this->getUser()) {
             return $this->redirectToRoute('account');
         } */

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        
        /* Inscription */
        $notification = null;

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (!$search_email) {
                $password = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                
                $this->entityManager->persist($user);  /* Persister/Figer l'entité user et prépare toi à être créer en bdd car j'ai besoin de l'enregistrer */
                $this->entityManager->flush(); /* Exécuter la persistance, l'enregistrer en bdd */

                $mail = new Mail();
                $content = "Bonjour ".$user->getFirstname()."</br>Bienvenue sur la première boutique dédié au made in France.</br></br>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestias eum, consequuntur cum deserunt, nobis maxime quod cupiditate nulla maiores id nesciunt ipsam officia eos sunt minima sapiente voluptatum repellendus amet praesentium autem iure voluptatem veritatis atque perspiciatis? Dolor, eum voluptate eligendi, adipisci, eius et minima modi odio nostrum voluptates deserunt.";
                $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue sur la Boutique SY-Shop', $content);

                $notification = "Votre inscription s'est correctement déroulée. Vous pouvez dés à présent vous connecter à votre compte.";
            } else {
                $notification = "L'email que vous avez renseigné existe déjà.";
            }
        }


        /* $form1 = $this->get('form.factory')->createNamedBuilder($formTypeA, 'form1name')
            ->add('foo', 'text')
            ->getForm();
 
        $form2 = $this->get('form.factory')->createNamedBuilder($formTypeB, 'form2name')
            ->add('bar', 'text')
            ->getForm();
    
            if('POST' === $request->getMethod()){
 
                if ($request->request->has('form1name') 
                {
                    // handle the first form
                }
         
                if ($request->request->has('form2name') 
                {
                    // handle the second form
                }
            } */


        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
            'categories' => $categories,
            'form' => $form->createView(),
            'notification' => $notification,
            'panier' => $panier/* ,
            'form1' => $form1->createView(),
            'form2' => $form2->createView() */
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
