<?php

namespace Vkovic\LaravelEventLog\Console\Commands;

use Illuminate\Console\Command;
use Vkovic\LaravelEventLog\LogCleaner;

class EventLogClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event-log:clean
                                {daysToKeep? : (optional) Records older than this will be cleaned.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old records from the `event_log` table';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $daysToKeep = $this->argument('daysToKeep') ?: config('event-log.days_to_keep');
        LogCleaner::clean($daysToKeep);

        $this->output->success("Logs older than $daysToKeep days cleaned successfully");
    }
}
