<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $faker = Faker::create();

        // Generating 8 sample users with realistic names and emails
        for ($i = 1; $i <= 8; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // You can adjust the password if needed
                'phone_number' => $faker->phoneNumber, // Sample phone number
                'remember_token' => str_random(10), // Generating a random remember token
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
