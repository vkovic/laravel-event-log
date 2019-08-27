<?php

namespace Vkovic\LaravelEventLog;

use Carbon\Carbon;

class LogCleaner
{
    /**
     * Clean old logs
     *
     * @param $daysToKeep
     */
    public static function clean($daysToKeep, $event = null)
    {
        \DB::table('event_log')
            ->where('created_at', '<', Carbon::now()->subDays($daysToKeep))
            ->delete();
    }

    /**
     * Clean old logs but not before delay timeout
     *
     * @param null $daysToKeep
     * @param int  $delay Delay in seconds
     */
    public static function delayedClean($daysToKeep, $delay = 3600)
    {
        // Before Laravel v5.8 TTL was in minutes
        if (version_compare('5.8', app()::VERSION) > 0) {
            $delay = $delay / 60;
        }

        \Cache::remember('event_log.last_clean', $delay, function () use ($daysToKeep) {
            self::clean($daysToKeep);

            return time();
        });
    }
}