<?php

namespace App\Entity;

use App\Repository\RowOrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RowOrderRepository::class)
 */
class RowOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $rowQuantity;

    /**
     * @ORM\Column(type="float")
     */
    private $rowTotalPrice;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, inversedBy="rowOrder", cascade={"persist", "remove"})
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=ShoppingCart::class, inversedBy="rowOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shoppingCart;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRowQuantity(): ?int
    {
        return $this->rowQuantity;
    }

    public function setRowQuantity(int $rowQuantity): self
    {
        $this->rowQuantity = $rowQuantity;

        return $this;
    }

    public function getRowTotalPrice(): ?float
    {
        return $this->rowTotalPrice;
    }

    public function setRowTotalPrice(float $rowTotalPrice): self
    {
        $this->rowTotalPrice = $rowTotalPrice;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getShoppingCart(): ?ShoppingCart
    {
        return $this->shoppingCart;
    }

    public function setShoppingCart(?ShoppingCart $shoppingCart): self
    {
        $this->shoppingCart = $shoppingCart;

        return $this;
    }
}