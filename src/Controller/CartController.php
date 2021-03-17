<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{


    private $session;
    private $em;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->session = $session;
        $this->em = $entityManager;

    }



    /**
     * @Route("/products", name="products")
     */
    public function index(): Response
    {
        $this->session();
        $products = $this->em->getRepository(Product::class)->findAll();

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'products' => $products,
        ]);
    }


    public function session()
    {
        $this->session->set('session', 'foo');
        $foo = $this->session->get('session');
        $filters = $this->session->get('filters', []);
    }
}
