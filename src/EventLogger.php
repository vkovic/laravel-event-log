<?php

namespace Vkovic\LaravelEventLog;

class EventLogger
{
    /**
     * Data to be logged
     *
     * @var array
     */
    protected $pending = [];

    /**
     * Log (loggable) event to database
     *
     * @param Loggable $event
     * @param string   $message
     *
     * @throws \Exception
     */
    public function log($event, $message = null)
    {
        if (self::isLoggable($event) === false) {
            throw new \Exception('To be loggable, event should use ' . Loggable::class . ' trait');
        }

        $this->pending['event'] = get_class($event);
        $this->pending['message'] = $event->logMessage() ?? $message;
        $this->pending['data'] = json_encode($event->logData());

        if (($model = $event->logRelated()) !== null) {
            $this->pending['related_id'] = $model->id;
            $this->pending['related_type'] = get_class($model);
        }
    }

    /**
     * Check if event is loggable
     *
     * @param object $event
     *
     * @return bool
     *
     * @throws \ReflectionException
     */
    public static function isLoggable($event)
    {
        return in_array(
            Loggable::class,
            array_keys((new \ReflectionClass($event))->getTraits())
        );
    }

    /**
     * Finally save pending data to database.
     * Also, from time to time, clear old logs
     */
    public function __destruct()
    {
        // To be able to create db log
        // we require at least event field to be set
        if (isset($this->pending['event'])) {
            // Add timestamps
            $this->pending['created_at']
                = $this->pending['updated_at']
                = \Carbon\Carbon::now();

            // Write pending data. We're saving with DB facade
            // to skip model events and potential recursion problems.
            \DB::table('event_log')->insert($this->pending);

            // Auto clean old logs
            if (config('event_log.auto_clean') === true) {
                $daysToKeep = config('event_log.days_to_keep');
                LogCleaner::delayedClean($daysToKeep);
            }
        }
    }
}