<?php

namespace Vkovic\LaravelEventLog;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Vkovic\LaravelEventLog\Console\Commands\EventLogClean;

class EventLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(package_path('database/migrations'));

        // Disable event logging functionality if config says so
        if (config('event-log.enabled') !== true) {
            return;
        }

        $this->publishes([
            package_path('config') => config_path()
        ]);

        $this->registerListener();
    }

    public function register()
    {
        $this->mergeConfigFrom(package_path('config/event-log.php'), 'event-log');
    }

    protected function registerCommands()
    {
        $this->commands(EventLogClean::class);
    }

    /**
     * Register listener
     */
    protected function registerListener()
    {
        $event = app(Dispatcher::class);
        $namespace = config('event-log.events');

        $event->listen($namespace, function (...$args) {
            // If we're listening to wildcard events,
            // then the arguments are different
            if (isset($args[1])) {
                $eventName = $args[0];
                $event = $args[1][0];
            } else {
                $eventName = null;
                $event = $args[0];
            }

            if (EventLogger::isLoggable($event)) {
                (new EventLogger)->log($event, $eventName);
            }
        });
    }
}
