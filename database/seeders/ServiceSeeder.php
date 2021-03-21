<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            ['category_id' => 1, 'name' => 'Automobile Services', 'description' => Str::random(50)],
            ['category_id' => 1, 'name' => 'Generator Repairs', 'description' => Str::random(50)],
            ['category_id' => 1, 'name' => 'Inverter & Solar Repairs', 'description' => Str::random(50)],
            ['category_id' => 1, 'name' => 'Laptop Repairs', 'description' => Str::random(50)],
            ['category_id' => 1, 'name' => 'Mobile Phone Repairs', 'description' => Str::random(50)],
            ['category_id' => 1, 'name' => 'Electronic Repairs', 'description' => Str::random(50)],
            ['category_id' => 1, 'name' => 'Air Conditioning Repairs', 'description' => Str::random(50)],
        ];

        foreach ($services as $service) {

            Service::create([
                'category_id'   => $service['category_id'],
                'name'          => $service['name'],
                'description'   => $service['description'],
                'status_id'     => 1
            ]);
        }
    }
}
