<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Repository\ProductStockRepository;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", defaults={"page": "1"}, methods="GET", name="product")
     * @Route("/product/page/{page<[1-9]\d*>}", methods="GET", name="product_paginated")
     */
    public function index(int $page, ProductRepository $productRepository)
    {
        $products = $productRepository->findNewest($page);
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/{id}", name="product-show")
     */
    public function show(Product $product)
    {
        var_dump($product);
        return $this->render('product/index.html.twig', [
            'products' => $product,
        ]);
    }
}
