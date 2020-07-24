<?php

namespace App\Controller;

use App\Entity\ProductOwner;
use App\Form\ProductOwnerType;
use App\Repository\ProductOwnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product/owner")
 */
class ProductOwnerController extends AbstractController
{
    /**
     * @Route("/", name="product_owner_index", methods={"GET"})
     */
    public function index(ProductOwnerRepository $productOwnerRepository): Response
    {
        return $this->render('product_owner/index.html.twig', [
            'product_owners' => $productOwnerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_owner_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productOwner = new ProductOwner();
        $form = $this->createForm(ProductOwnerType::class, $productOwner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productOwner);
            $entityManager->flush();

            return $this->redirectToRoute('product_owner_index');
        }

        return $this->render('product_owner/new.html.twig', [
            'product_owner' => $productOwner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_owner_show", methods={"GET"})
     */
    public function show(ProductOwner $productOwner): Response
    {
        return $this->render('product_owner/show.html.twig', [
            'product_owner' => $productOwner,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_owner_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductOwner $productOwner): Response
    {
        $form = $this->createForm(ProductOwnerType::class, $productOwner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_owner_index');
        }

        return $this->render('product_owner/edit.html.twig', [
            'product_owner' => $productOwner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_owner_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductOwner $productOwner): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productOwner->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productOwner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_owner_index');
    }
}
