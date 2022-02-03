<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use App\Entity\Category;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CategoryAccessoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @Route("/login", name="app_login")
     */
    public function login(CategoryRepository $category, AuthenticationUtils $authenticationUtils, Request $request, UserPasswordEncoderInterface $encoder): Response
    {
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
                $content = "Bonjour ".$user->getFirstname()."</br>Bienvenue sur la première boutique dédié au made in France.</br></br>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestias eum, consequuntur cum deserunt, nobis maxime quod cupiditate nulla maiores id nesciunt ipsam officia eos sunt minima sapiente voluptatum repellendus amet praesentium autem iure voluptatem veritatis atque perspiciatis? Dolor, eum voluptate eligendi, adipisci, eius et minima modi odio nostrum voluptates deserunt.
                ";
                $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue sur la Boutique SY-Shop', $content);

                $notification = "Votre inscription s'est correctement déroulée. Vous pouvez dés à présent vous connecter à votre compte.";
            } else {
                $notification = "L'email que vous avez renseigné existe déjà.";
            }


        }

        /* Login */
        $categories = $category->findAll();
        $category = $this->entityManager->getRepository(Category::class)->findAll();

        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
            'categories' => $categories,
            'category' => $category,
            'form' => $form->createView(),
            'notification' => $notification
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
