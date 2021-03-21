<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountTypes = [
            ['name' => 'Individual', 'description' => 'This is an account owned by an individual.'],
            ['name' => 'Business', 'description' => 'This is an account owned by a business.']
        ];

        foreach ($accountTypes as $type) {

            AccountType::create([
                'name'          => $type['name'],
                'description'   => $type['description']
            ]);

        }
    }
}
