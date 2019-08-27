<?php

namespace Vkovic\LaravelEventLog\Test\Support\Events;

use Vkovic\LaravelEventLog\Loggable;
use Vkovic\LaravelEventLog\Test\Support\Product;

class ProductSoldEvent
{
    use Loggable;

    /**
     * @var Product
     */
    public $product;

    /**
     * @var int
     */
    public $quantity;

    /**
     * Create a new event instance
     *
     * @param Product $product
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;

        $this->quantity = $product->quantity;
    }

    public function logMessage()
    {
        return 'Product sold: ' . $this->product->name;
    }

    public function logRelated()
    {
        return $this->product;
    }

    public function logData()
    {
        return [
            'price' => $this->product->price,
            'quantity' => $this->quantity,
        ];
    }
}