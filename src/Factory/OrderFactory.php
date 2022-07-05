<?php

namespace App\Factory;

use App\Entity\Orders;
use App\Entity\Orderdetail;
use App\Entity\Products;

/**
 * Class OrderFactory.
 */
class OrderFactory
{
    /**
     * Creates an order.
     */
    public function create(): Orders
    {
        $order = new Orders();
        $order
            ->setStatus(Orders::STATUS_CART)
            ->setDate(new \DateTime())
            ->setDelivery(new \DateTime());

        return $order;
    }

    /**
     * Creates an item for a product.
     */
    public function createItem(Products $product): Orderdetail
    {
        $item = new Orderdetail();
        $item->setProduct($product);
        $item->setQuantity(1);

        return $item;
    }
}