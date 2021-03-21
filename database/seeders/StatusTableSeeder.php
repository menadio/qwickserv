<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'Active', 'description' => 'Active status'],
            ['name' => 'Deactive', 'description' => 'Deactive status'],
            ['name' => 'Approved', 'description' => 'Approved status'],
            ['name' => 'Unapproved', 'description' => 'Unapproved status'],
            ['name' => 'Reserved', 'description' => 'Reserved status'],
            ['name' => 'Completed', 'description' => 'Completed status'],
            ['name' => 'Pending', 'description' => 'Pending status'],
            ['name' => 'Paid', 'description' => 'Paid status'],
        ];

        foreach ($statuses as $status) {
            Status::create([
                'name'          => $status['name'],
                'description'   => $status['description']
            ]);
        }
    }
}
