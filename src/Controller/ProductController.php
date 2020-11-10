<?php

namespace App\Controller;

use App\Entity\RowOrder;
use App\Entity\ShoppingCart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Security\Core\User\UserInterface;

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
    public function addToCart(UserInterface $user, $id): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $addedProduct = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $checkExProd = $this->getDoctrine()->getRepository(RowOrder::class)->getRowOrderWhereProduct($id);
        $rowOrder = new RowOrder();
        $rowOrder->setRowQuantity(1);
        $rowOrder->setProduct($addedProduct);
        $rowOrder->setRowTotalPrice($addedProduct->getUnitPrice() * $rowOrder->getRowQuantity());

        $authId = $user->getId();
        $existingCart = $this->getDoctrine()->getRepository(ShoppingCart::class)->getCartWhereUser($authId);
        if(!$existingCart) {

            $cart = new ShoppingCart();
            $cart->setCustomer($user);
            $rowOrder->setShoppingCart($cart);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($cart);
            $manager->persist($rowOrder);
            $manager->flush();
        } else {
                $ex = $user->getShoppingCart();
                $rowOrder->setShoppingCart($ex);
                $manager = $this->getDoctrine()->getManager();
                if($checkExProd) {
                    $checkExProd[0]->setRowQuantity($checkExProd[0]->getRowQuantity() + 1);
                    $checkExProd[0]->setRowTotalPrice($addedProduct->getUnitPrice() * $checkExProd[0]->getRowQuantity());
                } else {
                    $manager->persist($rowOrder);
                }
            $manager->flush();
        }

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart", name="cart")
     */
    public function showCart(UserInterface $user): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $rowOrders = $user->getShoppingCart()->getRowOrders();
        return $this->render('skeleton/checkout.html.twig', [
            'controller_name' => 'ProductController',
            'roworders'=> $rowOrders,
            'categories' => $categories
        ]);
    }
}
