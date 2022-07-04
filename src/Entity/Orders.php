<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use App\Factory\OrderFactory;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Delivery;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Status = self::STATUS_CART;
    
    /**
     * An order that is in progress, not placed yet.
     *
     * @var string
     */
    const STATUS_CART = 'cart';
 
    /**
     * @ORM\OneToMany(targetEntity=Orderdetail::class, mappedBy="orderRef", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getDelivery(): \DateTimeInterface
    {
        return $this->Delivery;
    }

    public function setDelivery(\DateTimeInterface $Delivery): self
    {
        $this->Delivery = $Delivery;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }


    public function addOrderdetail(Orderdetail $orderdetail): self
    {
        if (!$this->items->contains($orderdetail)) {
            $this->items[] = $orderdetail;
            $orderdetail->setIDOrder($this);
        }

        return $this;
    }

    public function removeOrderdetail(Orderdetail $orderdetail): self
    {
        if ($this->item->removeElement($orderdetail)) {
            // set the owning side to null (unless already changed)
            if ($orderdetail->getIDOrder() === $this) {
                $orderdetail->setIDOrder(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Orderdetail>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Orderdetail $item): self
    {
        foreach ($this->getItems() as $existingItem) {
            // The item already exists, update the quantity
            if ($existingItem->equals($item)) {
                $existingItem->setQuantity(
                    $existingItem->getQuantity() + $item->getQuantity()
                );
                return $this;
            }
        }

        $this->items[] = $item;
        $item->setOrderRef($this);

        return $this;
    }

    public function removeItem(Orderdetail $items): self
    {
        if ($this->items->removeElement($items)) {
            // set the owning side to null (unless already changed)
            if ($items->getOrderRef() === $this) {
                $items->setOrderRef(null);
            }
        }

        return $this;
    }
    /**
    * Removes all items from the order.
    *
    * @return $this
    */
    public function removeItems(): self
    {
        foreach ($this->getItems() as $item) {
         $this->removeItem($item);
        }

        return $this;
    }
    /**
     * Calculates the order total.
     * @return float
     */
    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getItems() as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }
    public function __toString()
    {
        return $this->Delivery;
    }
    public function Date__toString()
    {
        return $this->Date;
    }
}