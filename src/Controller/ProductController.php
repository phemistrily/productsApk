<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     * @Route("/page/{page<[1-9]\d*>}", methods="GET", name="product_paginated")
     */
    public function index(ProductRepository $productRepository, int $page = 1): Response
    {
        $products = $productRepository->findNewest($page);
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        
        

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->checkEan13IsCorrect($product->getBarCodeEan13())) {
                $form->get('bar_code_ean13')->addError(new FormError('Kod jest nie prawidłowy'));
                return $this->render('product/edit.html.twig', [
                    'product' => $product,
                    'form' => $form->createView(),
                ]);
            }
            else {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($product);
                $entityManager->flush();
            }
            

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    private function checkEan13IsCorrect(string $ean13): bool
    {
        if (strlen($ean13) != 13) {
            return false;
        }
        $evenSum = $ean13[1] + $ean13[3] + $ean13[5] + $ean13[7] + $ean13[9] + $ean13[11];
        $evenSum *= 3;
        $oddSum = $ean13[0] + $ean13[2] + $ean13[4] + $ean13[6] + $ean13[8] + $ean13[10];
        $totalSum = $evenSum + $oddSum;
        $nextTen = (ceil($totalSum/10))*10;
        $checkDigit = $nextTen - $totalSum;
        if($checkDigit != $ean13[12]) {
            return false;
        }
        return true;
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->checkEan13IsCorrect($product->getBarCodeEan13())) {
                $form->get('bar_code_ean13')->addError(new FormError('Kod jest nie prawidłowy'));
                return $this->render('product/edit.html.twig', [
                    'product' => $product,
                    'form' => $form->createView(),
                ]);
            }
            else {
                $this->getDoctrine()->getManager()->flush();
            }
            

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
