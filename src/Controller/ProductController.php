<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;

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
    public function show($id, ProductRepository $repository): Response {
        $product = $repository->find($id);

        if( is_null($product) ) {
            throw $this->createNotFoundException('Product not found');
        }
        
        // dd($product);
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
