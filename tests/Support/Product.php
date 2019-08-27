<?php

namespace Vkovic\LaravelEventLog\Test\Support;

use Illuminate\Database\Eloquent\Model;
use Vkovic\LaravelEventLog\HasLoggedEvents;
use Vkovic\LaravelEventLog\Test\Support\Events\ProductSoldEvent;

class Product extends Model
{
    use HasLoggedEvents;

    protected $table = 'products';

    protected static function boot()
    {
        parent::boot();

        static::updated(function (Product $product) {
            if ($product->isDirty('quantity')) {
                // Check if product quantity is smaller than before,
                // so we know product actually sold - not arrived
                $diff = $product->getOriginal('quantity') - $product->quantity;

                if ($diff > 0) {
                    event(new ProductSoldEvent($product));
                }
            }
        });
    }
}