<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {   
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function add($id)
    {
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }


        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id)
    {
        $cart = $this->session->get('cart', []);

        unset($cart[$id]);

        return $this->session->set('cart', $cart);
    }

    public function decrease($id)
    {   
        $cart = $this->session->get('cart', []);

        // Vérifier si la quantité du notre produit = 1

        if ($cart[$id] > 1) {
            // Retirer une quantité => faire -1
            $cart[$id]--;
        } else {
            // Supprimer mon produit
            unset($cart[$id]);
        }

        return $this->session->set('cart', $cart); 
    }

    public function getFull()
    {
        $cartComplete = [];

        if ($this->get()) {
            //dd($this->get());
            foreach ($this->get() as $id => $quantity) {

                $product = $this->entityManager->getRepository(product::class)->find($id);
                $product_object = !empty($product) ? $product->getProduct()  : null;
                // $product = $this->entityManager->getRepository(product::class)->findOneBy([
                //     'product' => $product_object,
                //     'size' =>  8
                // ]);
                //dd($product)->getName()->getSize();
                // Pour supprimer un produit qui n'existe pas si l'utilise fait /cart/add/xxx
                if (!$product_object) {
                    $this->delete($id);
                    continue;
                }
                if (!$product) {
                    $this->delete($id);
                    continue;
                }

                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity,
                    'product' => $product
                ];
            }
        }/* dump($cartComplete); */
        return $cartComplete;
    }
}