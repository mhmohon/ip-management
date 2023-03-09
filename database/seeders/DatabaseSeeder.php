<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\IPAddress;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()
                        ->has(IPAddress::factory()->count(5))
                        ->create([
                            'name' => 'Mosharrf Hossain',
                            'email' => 'mhmosharrf@gmail.com',
                            'password' => bcrypt("password"),
                        ]);
        \App\Models\User::factory()
                        ->has(IPAddress::factory()->count(10))
                        ->create([
                            'name' => 'Dummy User',
                            'email' => 'dummyuser@gmail.com',
                            'password' => bcrypt("password"),
                        ]);
    }
}
