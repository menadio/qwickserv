<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateBusinessSearchCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $businesses;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($businesses)
    {
        $this->businesses = $businesses;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $businesses = $this->businesses;

        foreach ($businesses as $business) {

            $business->search_count++;

            $business->save();
        }
    }
}
