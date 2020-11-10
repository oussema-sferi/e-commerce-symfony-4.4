<?php

namespace App\Entity;

use App\Repository\ShoppingCartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShoppingCartRepository::class)
 */
class ShoppingCart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="shoppingCart", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity=RowOrder::class, mappedBy="shoppingCart")
     */
    private $rowOrders;

    public function __construct()
    {
        $this->rowOrders = new ArrayCollection();
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection|RowOrder[]
     */
    public function getRowOrders(): Collection
    {
        return $this->rowOrders;
    }

    public function addRowOrder(RowOrder $rowOrder): self
    {
        if (!$this->rowOrders->contains($rowOrder)) {
            $this->rowOrders[] = $rowOrder;
            $rowOrder->setShoppingCart($this);
        }

        return $this;
    }

    public function removeRowOrder(RowOrder $rowOrder): self
    {
        if ($this->rowOrders->removeElement($rowOrder)) {
            // set the owning side to null (unless already changed)
            if ($rowOrder->getShoppingCart() === $this) {
                $rowOrder->setShoppingCart(null);
            }
        }

        return $this;
    }


}
