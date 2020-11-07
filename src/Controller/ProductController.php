<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Entity\Category;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        return $this->render('skeleton/product.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route("/productsbycategory/{id}", name="productsbycategory")
     */
    public function productsByCategory($id): Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $productsByCat = $category->getProducts();
        return $this->render('skeleton/product.html.twig', [
            'controller_name' => 'ProductController',
            'selectedCategory' => $category,
            'productsByCategory' => $productsByCat
        ]);
    }

    /**
     * @Route("/singleproduct/{id}", name="singleproduct")
     */
    public function singleProduct($id): Response
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        return $this->render('skeleton/single.html.twig', [
            'controller_name' => 'ProductController',
            'singleproduct' => $product,
        ]);
    }
}
