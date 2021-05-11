<?php

namespace App\Nova\Metrics;

use App\Models\Booking;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class BookingPerStatus extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Booking::class, 'status_id')
            ->label(function ($value) {
                switch ($value) {
                    case 5:
                        return 'Reserved';
                    case 8:
                        return 'Paid';
                    case 9:
                        return 'Cancelled';
                    default:
                        return 'None';
                }
            });
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
        return 'booking-per-status';
    }
}
