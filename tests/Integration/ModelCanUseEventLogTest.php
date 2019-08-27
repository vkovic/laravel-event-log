<?php

namespace Vkovic\LaravelEventLog\Test\Integration;

use Vkovic\LaravelEventLog\EventLogModel;
use Vkovic\LaravelEventLog\Test\Support\Product;
use Vkovic\LaravelEventLog\Test\TestCase;

class ModelCanUseEventLogTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_use_event_log()
    {
        $product = new Product;
        $product->name = 'Cool product';
        $product->quantity = 10;
        $product->price = 199;
        $product->save();

        // Reduce quantity to simulate sell
        $product->refresh();
        $product->quantity = 4;
        $product->save();

        $this->assertSame(1, EventLogModel::count());

        $elog = EventLogModel::first();

        $this->assertEquals(4, $elog->data->quantity);
        $this->assertEquals(199, $elog->data->price);
        $this->assertEquals($elog->relatedModel->id, $product->id);
    }
}

