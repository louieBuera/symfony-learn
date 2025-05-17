<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;

final class ProductController extends AbstractController
{

    #[Route('/product', name: 'products_index')]
    public function index(ProductRepository $repository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $repository->findAll()
        ]);
    }

    #[Route('/product/{id<\d+>}', name: 'products_show')]
    public function show(Product $product): Response {
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
