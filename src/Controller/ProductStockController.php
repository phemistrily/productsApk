<?php

namespace App\Controller;

use App\Entity\ProductStock;
use App\Form\ProductStockType;
use App\Repository\ProductStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stock")
 */
class ProductStockController extends AbstractController
{
    /**
     * @Route("/", name="product_stock_index", methods={"GET"})
     */
    public function index(ProductStockRepository $productStockRepository): Response
    {
        return $this->render('product_stock/index.html.twig', [
            'product_stocks' => $productStockRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_stock_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productStock = new ProductStock();
        $form = $this->createForm(ProductStockType::class, $productStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productStock);
            $entityManager->flush();

            return $this->redirectToRoute('product_stock_index');
        }

        return $this->render('product_stock/new.html.twig', [
            'product_stock' => $productStock,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_stock_show", methods={"GET"})
     */
    public function show(ProductStock $productStock): Response
    {
        return $this->render('product_stock/show.html.twig', [
            'product_stock' => $productStock,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_stock_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductStock $productStock): Response
    {
        $form = $this->createForm(ProductStockType::class, $productStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_stock_index');
        }

        return $this->render('product_stock/edit.html.twig', [
            'product_stock' => $productStock,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_stock_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductStock $productStock): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productStock->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productStock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_stock_index');
    }
}
