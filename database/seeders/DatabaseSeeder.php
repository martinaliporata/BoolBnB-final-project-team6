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

        ServiceSeeder::class,
        SponsorshipSeeder::class,
        ApartmentSeeder::class,
        ApartmentServiceSeeder::class,
        MessageSeeder::class,
        ViewSeeder::class,


       ]);


    }
}
