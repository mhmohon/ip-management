<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\IPAddress;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->create([
                'name' => 'Dummy User',
                'email' => 'dummyuser@gmail.com',
                'password' => bcrypt("password"),
            ]);
        User::factory()
            ->has(IPAddress::factory()->count(5))
            ->create([
                'name' => 'Mosharrf Hossain',
                'email' => 'mhmosharrf@gmail.com',
                'password' => bcrypt("password"),
            ]);
        User::factory()
            ->has(IPAddress::factory()->count(10))
            ->create([
                'name' => 'Dummy User 2',
                'email' => 'dummyuser2@gmail.com',
                'password' => bcrypt("password"),
            ]);
    }
}
