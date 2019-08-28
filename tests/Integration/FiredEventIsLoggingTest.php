<?php

namespace Vkovic\LaravelEventLog\Test\Integration;

use Vkovic\LaravelEventLog\EventLogModel;
use Vkovic\LaravelEventLog\Test\Support\Events\Event;
use Vkovic\LaravelEventLog\Test\Support\Events\EventWithoutTrait;
use Vkovic\LaravelEventLog\Test\Support\Events\ProductSoldEvent;
use Vkovic\LaravelEventLog\Test\Support\Product;
use Vkovic\LaravelEventLog\Test\TestCase;

class FiredEventIsLoggingTest extends TestCase
{

    public function should_not_log_when_trait_omitted()
    {
        event(new EventWithoutTrait);

        $this->assertEquals(0, EventLogModel::count());
    }

    /**
     * @test
     */
    public function log_event()
    {
        $simpleEventClass = Event::class;
        event(new $simpleEventClass);

        $this->assertSame(1, EventLogModel::count());

        $elog = EventLogModel::first();

        $this->assertEquals($simpleEventClass, $elog->event);
        $this->assertEquals('Event "' . $simpleEventClass . '" logged', $elog->message);
        $this->assertNull($elog->data);
        $this->assertNull($elog->related_type);
        $this->assertNull($elog->related_id);
    }

    /**
     * @test
     */
    public function log_event_with_model()
    {
        $product = factory(Product::class)->create();
        event(new ProductSoldEvent($product));

        $this->assertSame(1, EventLogModel::count());

        $elog = EventLogModel::first();

        $this->assertEquals($product->quantity, $elog->data->quantity);
        $this->assertEquals($product->price, $elog->data->price);
        $this->assertEquals($elog->relatedModel->id, $product->id);
    }

    /**
     * @test
     */
    public function log_event_when_fired_from_model()
    {
        $product = factory(Product::class)->create([
            'quantity' => 10
        ]);

        // Simulate product sell (this'll trigger event)
        $product->quantity = 4;
        $product->save();

        $this->assertSame(1, EventLogModel::count());

        $elog = EventLogModel::first();

        $this->assertEquals(4, $elog->data->quantity);
        $this->assertEquals($product->price, $elog->data->price);
        $this->assertEquals($elog->relatedModel->id, $product->id);
    }
}