<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartments = Apartment::all();
        $services = Service::all()->pluck('id');

        foreach ($apartments as $apartment) {

            $randomServiceCount = rand(1, $services->count());

            $randomServices = collect($services)->random($randomServiceCount);


            $apartment->services()->sync($randomServices);
        }
    }
}
