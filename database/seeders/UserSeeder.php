<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'superadmin@qwickserv.com',
            'password'  => Hash::make('qW1ck5er^admin'),
            'email_verified_at' => now(),
            'otp'   => 000000,
            'account_type_id'   => 1,
            'consent'   => true 
        ]);

        User::create([
            'email' => 'info@qwickserv.com',
            'password'  => Hash::make('qW1ck5er^info'),
            'email_verified_at' => now(),
            'otp'   => 000000,
            'account_type_id'   => 1,
            'consent'   => true 
        ]);

        User::create([
            'email' => 'hello@qwickserv.com',
            'password'  => Hash::make('qW1ck5er^hello'),
            'email_verified_at' => now(),
            'otp'   => 000000,
            'account_type_id'   => 1,
            'consent'   => true 
        ]);
    }
}
