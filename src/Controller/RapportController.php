<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Form\RapportType;
use App\Repository\RapportRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;



/**
 * @Route("/rapport")
 */
class RapportController extends AbstractController
{


    private $session;
    private $em;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->session = $session;
        $this->em = $entityManager;

    }


    /**
     * @Route("/frontreport", name="front_report")
     */
    public function frontReport(RapportRepository $rapportRepository): Response
    {
        $rapport = $rapportRepository->findAll();

        return $this->render('rapport/front.html.twig', [
            'controller_name' => 'RapportController',
            'rapports' => $rapport,
        ]);
    }



    /**
     * @Route("/", name="rapport_index", methods={"GET"})
     * @Security("is_granted(['ROLE_ADMIN', 'ROLE_BOEKHOUDER'])")

     */
    public function index(RapportRepository $rapportRepository): Response
    {
        return $this->render('rapport/index.html.twig', [
            'rapports' => $rapportRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rapport_new", methods={"GET","POST"})
     * @Security("is_granted(['ROLE_ADMIN', 'ROLE_BOEKHOUDER'])")
     */
    public function new(Request $request): Response
    {
        $rapport = new Rapport();
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rapport);
            $entityManager->flush();

            return $this->redirectToRoute('rapport_index');
        }

        return $this->render('rapport/new.html.twig', [
            'rapport' => $rapport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rapport_show", methods={"GET"})
     * @Security("is_granted(['ROLE_ADMIN', 'ROLE_BOEKHOUDER'])")
     */
    public function show(Rapport $rapport): Response
    {
        return $this->render('rapport/show.html.twig', [
            'rapport' => $rapport,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rapport_edit", methods={"GET","POST"})
     * @Security("is_granted(['ROLE_ADMIN', 'ROLE_BOEKHOUDER'])")
     */
    public function edit(Request $request, Rapport $rapport): Response
    {
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rapport_index');
        }

        return $this->render('rapport/edit.html.twig', [
            'rapport' => $rapport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rapport_delete", methods={"DELETE"})
     * @Security("is_granted(['ROLE_ADMIN', 'ROLE_BOEKHOUDER'])")
     */
    public function delete(Request $request, Rapport $rapport): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rapport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rapport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rapport_index');
    }






}
