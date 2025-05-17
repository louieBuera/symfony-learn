<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Form\ProductForm;

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
    
    #[Route('/product/new', name: 'products_new')]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $product = new Product;

        $form = $this->createForm(ProductForm::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $manager->persist($product);

            $manager->flush();

            return $this->redirectToRoute('products_show', [
                'id' => $product->getId()
            ]);
        }

        return $this->render('product/new.html.twig', [
            'form' => $form
        ]);
    }
}
