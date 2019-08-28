<?php

namespace Vkovic\LaravelEventLog\Test\Integration;

use Vkovic\LaravelEventLog\EventLogModel;
use Vkovic\LaravelEventLog\Test\Support\Events\SimpleEvent;
use Vkovic\LaravelEventLog\Test\TestCase;

class EventsLoggingTest extends TestCase
{
    /**
     * @test
     */
    public function simple_event_been_written_do_logs_correctly()
    {
        $simpleEventClass = SimpleEvent::class;
        event(new $simpleEventClass);

        $this->assertSame(1, EventLogModel::count());

        $elog = EventLogModel::first();

        $this->assertEquals($simpleEventClass, $elog->event);
        $this->assertEquals('Event "' . $simpleEventClass . '" logged', $elog->message);
        $this->assertNull($elog->data);
        $this->assertNull($elog->related_type);
        $this->assertNull($elog->related_id);
    }
}