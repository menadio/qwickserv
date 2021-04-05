<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateBusinessViewsCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $business;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($business)
    {
        $this->business = $business;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $business = $this->business;

        $business->views_count++;

        $business->save();
    }
}
