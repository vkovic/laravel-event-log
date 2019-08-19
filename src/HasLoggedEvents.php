<?php

namespace Vkovic\LaravelEventLog;

trait HasLoggedEvents
{
    /**
     * Get the entity's notifications.
     *
     * @param string|null $type
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function loggedEvents($type = null)
    {
        $relation = $this->morphMany(EventLogModel::class, 'related')->orderBy('created_at', 'desc');

        return $type === null
            ? $relation
            : $relation->where('event', $type);
    }
}