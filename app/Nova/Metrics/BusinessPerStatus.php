<?php

namespace App\Nova\Metrics;

use App\Models\Business;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class BusinessPerStatus extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Business::class, 'status_id')
            ->label(function ($value) {
                switch ($value) {
                    case 3:
                        return 'Approved';
                    case 4:
                        return 'Unapproved';
                    case 2:
                        return 'Deactivated';
                    default:
                        return 'None';
                }
            })
            ->colors([
                'Approved' => '#059669',
                'Unapproved' => '#EF4444',
                'Deactivated' => '#FBBF24'
            ]);
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'business-per-status';
    }
}
