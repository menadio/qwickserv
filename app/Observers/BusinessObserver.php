<?php

namespace App\Observers;

use App\Models\Business;
use App\Models\BusinessHour;
use App\Models\WeekDay;

class BusinessObserver
{
    /**
     * Handle the Business "created" event.
     *
     * @param  \App\Models\Business  $business
     * @return void
     */
    public function created(Business $business)
    {
        // get all week days
        $weekDays = WeekDay::all();

        // create business hours
        foreach ($weekDays as $day) {

            BusinessHour::create([
                'business_id'   => $business->id,
                'week_day_id'   => $day->id
            ]);
        }
    }

    /**
     * Handle the Business "updated" event.
     *
     * @param  \App\Models\Business  $business
     * @return void
     */
    public function updated(Business $business)
    {
        //
    }

    /**
     * Handle the Business "deleted" event.
     *
     * @param  \App\Models\Business  $business
     * @return void
     */
    public function deleted(Business $business)
    {
        //
    }

    /**
     * Handle the Business "restored" event.
     *
     * @param  \App\Models\Business  $business
     * @return void
     */
    public function restored(Business $business)
    {
        //
    }

    /**
     * Handle the Business "force deleted" event.
     *
     * @param  \App\Models\Business  $business
     * @return void
     */
    public function forceDeleted(Business $business)
    {
        //
    }
}
