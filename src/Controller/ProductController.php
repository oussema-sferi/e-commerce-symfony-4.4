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
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $productsByCat = $category->getProducts();
        return $this->render('skeleton/product.html.twig', [
            'controller_name' => 'ProductController',
            'selectedCategory' => $category,
            'productsByCategory' => $productsByCat,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/singleproduct/{id}", name="singleproduct")
     */
    public function singleProduct($id): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        return $this->render('skeleton/single.html.twig', [
            'controller_name' => 'ProductController',
            'singleproduct' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/addtocart/{id}", name="addtocart")
     */
    public function addToCart($id): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        return $this->render('skeleton/checkout.html.twig', [
            'controller_name' => 'ProductController',
            'singleproduct' => $product,
            'categories' => $categories
        ]);
    }
}
