<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicesData = [
            ['nome' => 'Wi-Fi gratuito'],
            ['nome' => 'Aria condizionata'],
            ['nome' => 'Parcheggio privato'],
            ['nome' => 'Piscina'],
            ['nome' => 'Palestra'],
            ['nome' => 'TV satellitare'],
            ['nome' => 'Cucina attrezzata'],
            ['nome' => 'Animali ammessi'],
            ['nome' => 'Lavatrice'],
            ['nome' => 'Balcone o terrazza'],
        ];
    }
}
