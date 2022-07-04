<?php

namespace App\Entity;

use App\Repository\OrderdetailRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OrderdetailRepository::class)
 */
class Orderdetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Orders::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderRef;

    /**
     * @ORM\ManyToOne(targetEntity=Products::class, inversedBy="orderdetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(1)
     */
    private $Quantity;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderRef(): ?Orders
    {
        return $this->orderRef;
    }

    public function setOrderRef(?Orders $orderRef): self
    {
        $this->orderRef = $orderRef;

        return $this;
    }

    public function getproduct(): ?Products
    {
        return $this->product;
    }

    public function setproduct(?Products $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }
    

      /**
     * Calculates the item total.
     * @return float|int
     */
    public function getTotal(): float
    {
        return $this->getproduct()->getPrice() * $this->getQuantity();
    }

    /**
     * Tests if the given item given corresponds to the same order item.
     * @param Orderdetail $item
     * @return bool
     */
    public function equals(Orderdetail $item): bool
    {
        return $this->getproduct()->getId() === $item->getproduct()->getId();
    }


}