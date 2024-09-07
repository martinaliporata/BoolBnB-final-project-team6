<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Genera dati per appartamenti da 1 a 10
        for ($apartmentId = 1; $apartmentId <= 10; $apartmentId++) {
            // Numero casuale di indirizzi IP per ogni appartamento (da 1 a 10)
            $numberOfIPs = rand(1, 10);

            for ($i = 0; $i < $numberOfIPs; $i++) {
                DB::table('views')->insert([
                    'ip_address' => $faker->ipv4,  // Genera un indirizzo IP falso
                    'apartment_id' => $apartmentId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
