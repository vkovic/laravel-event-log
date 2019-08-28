<?php

namespace Vkovic\LaravelEventLog\Test\Integration;

use Carbon\Carbon;
use Vkovic\LaravelEventLog\EventLogModel;
use Vkovic\LaravelEventLog\LogCleaner;
use Vkovic\LaravelEventLog\Test\TestCase;

class LogCleanerTest extends TestCase
{
    /**
     * @test
     */
    public function can_clean_logs()
    {
        factory(EventLogModel::class, 6)->create([
            'created_at' => Carbon::now()->subDays(100)->startOfDay()
        ]);

        factory(EventLogModel::class, 7)->create([
            'created_at' => Carbon::now()->subDays(100)->endOfDay()
        ]);

        LogCleaner::clean(100);

        $this->assertEquals(7, EventLogModel::count());
    }
}