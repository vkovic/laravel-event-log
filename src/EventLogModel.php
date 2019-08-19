<?php

namespace Vkovic\LaravelEventLog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EventLogModel extends Model
{
    protected $table = 'event_log';

    protected $casts = [
        'data' => 'object'
    ];

    public function relatedModel()
    {
        return $this->morphTo('related');
    }

    public function scopeToday(Builder $query)
    {
        return $query->where('created_at', '>=', Carbon::today());
    }

    public function scopeYesterday(Builder $query)
    {
        return $query->where('created_at', '>=', Carbon::yesterday())
            ->where('created_at', '<=', Carbon::yesterday()->endOfDay());
    }

    public function scopeThisWeek(Builder $query)
    {
        return $query->where('created_at', '>=', Carbon::now()->startOfWeek());
    }

    public function scopeLastWeek(Builder $query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subWeek(1)->startOfWeek())
            ->where('created_at', '<=', Carbon::now()->subWeek(1)->endOfWeek());
    }

    public function scopeThisMonth(Builder $query)
    {
        return $query->where('created_at', '>=', Carbon::now()->startOfMonth());
    }

    public function scopeLastMonth(Builder $query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subMonth(1)->startOfMonth())
            ->where('created_at', '<=', Carbon::now()->subMonth(1)->endOfMonth());
    }

    /**
     * Scope events from days ago (start of the day)
     *
     * @param Builder $query
     * @param int     $days
     *
     * @return Builder
     */
    public function ScopeFromDaysAgo(Builder $query, $days = 1)
    {
        return $query->where('created_at', '>=', Carbon::today()->subDays($days));
    }

    /**
     * Scope events from months ago (start of the day of first day in that mont)
     *
     * @param Builder $query
     * @param int     $months
     *
     * @return Builder
     */
    public function ScopeFromMonthsAgo(Builder $query, $months = 1)
    {
        return $query->where('created_at', '>=', Carbon::today()->subMonths($months));
    }
}