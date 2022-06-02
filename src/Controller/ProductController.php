<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\Mapping\Id;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/produit')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'product_show', methods: ['GET'])]
    public function show(Product $product, ProductRepository $productRepository): Response
    {
        $relatedProducts = $productRepository->findBy(['category' => $product->getCategory()->getId()], ['id' => 'DESC'], 4);
        if (in_array($product, $relatedProducts)) {
            $index = array_search($product, $relatedProducts);
            unset($relatedProducts[$index]);
            $otherProduct = $productRepository->findBy(['category' => $product->getCategory()->getId()], ['id' => 'DESC'], 1, 4);
            array_push($relatedProducts, $otherProduct[0]);
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'category' => $relatedProducts
        ]);
    }
}
