<?php

return [
    // Events to log. May use arrays and wildcards.
    'events' => 'App\Events\*',

    // If `auto_clean` is enabled, every once in a
    // while (minimum 1 hour), when writing logs
    // we will clean old logs
    // (while respecting `days_to_keep` option)
    'auto_clean' => false,

    // How log we'll keep logs.
    // This applies either while using auto clean
    // functionality or console command
    // (`event-log:clean` - as default param)
    'days_to_keep' => 365,

    // If enabled is false, we'll skip log writing
    'enabled' => env('EVENT_LOG_ENABLED', true),
];