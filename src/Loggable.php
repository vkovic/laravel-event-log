<?php

namespace Vkovic\LaravelEventLog;

use Illuminate\Database\Eloquent\Model;

trait Loggable
{
    /**
     * @return string
     */
    public function logEvent()
    {
        return static::class;
    }

    /**
     * @return string
     */
    public function logMessage()
    {
        return 'Event "' . self::class . '" logged';
    }

    /**
     * @return Model|null
     */
    public function logRelated()
    {
        return null;
    }

    /**
     * @return array|null
     */
    public function logData()
    {
        return null;
    }
}