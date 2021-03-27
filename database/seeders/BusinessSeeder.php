<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->count(10)->create()->each(function($user) {
            $user->business()->save(\App\Models\Business::factory()->make());
        });
    }
}
