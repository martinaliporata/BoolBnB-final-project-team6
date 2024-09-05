<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsorship;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call([

        ApartmentSeeder::class,
        UserSeeder::class,
        MessageSeeder::class,
        ServiceSeeder::class,
        SponsorshipSeeder::class,
        ViewSeeder::class,

       ]);


    }
}
