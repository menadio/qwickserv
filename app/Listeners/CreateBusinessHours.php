<?php

namespace App\Listeners;

use App\Events\BusinessCreated;
use App\Models\BusinessHour;
use App\Models\WeekDay;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreateBusinessHours implements ShouldQueue
{
    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    // public $delay = 60;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BusinessCreated  $event
     * @return void
     */
    public function handle(BusinessCreated $event)
    {
        // get all week days
        $weekDays = WeekDay::all();

        // create business hours
        foreach ($weekDays as $day) {

            BusinessHour::create([
                'business_id'   => $event->business->id,
                'week_day_id'   => $day->id
            ]);
        }
    }
}
