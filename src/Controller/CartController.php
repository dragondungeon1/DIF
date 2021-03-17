<?php

namespace App\Controller;

use App\Entity\Factuur;
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
     * @Route("/products", name="cart")

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


    /**
     * @Route("/facturen", name="facturen")
     */
    public function front(): Response
    {
        $this->session();
        $factuurs = $this->em->getRepository(Factuur::class)->findAll();

        return $this->render('factuur/front.html.twig', [
            'controller_name' => 'FactuurController',
            'factuurs' => $factuurs,
        ]);
    }


    public function session()
    {
        $this->session->set('session', 'foo');
        $foo = $this->session->get('session');
        $filters = $this->session->get('filters', []);
    }
}
