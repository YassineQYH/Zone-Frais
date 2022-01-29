<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private $entityManager;
        
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;  /* Permet d'aller chercher des informations en bdd graçe à l'orm doctrine */
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder, CategoryRepository $category)
    {
        $notification = null;

        $categories = $category->findAll();

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

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification,
            'categories' => $categories
        ]);
    }
}
