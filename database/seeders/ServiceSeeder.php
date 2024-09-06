<?php

namespace Database\Seeders;

use App\Models\Service;
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
                'WiFi gratuito',
                'Colazione inclusa',
                'Aria condizionata',
                'Parcheggio gratuito',
                'Servizio in camera',
                'Animali ammessi',
                'Piscina',
                'Palestra',
                'Spa e centro benessere',
                'TV satellitare',
                'Minibar',
                'Cassaforte in camera',
                'Accesso per disabili',
                'Deposito bagagli',
                'Servizio navetta',
                'Noleggio biciclette',
                'Area giochi per bambini',
                'Sala conferenze',
                'Bar',
                'Ristorante',
                'Servizio lavanderia',
                'Asciugacapelli',
                'Ferro da stiro',
                'Reception 24 ore su 24'
        ];



        foreach ($servicesData as $service) {
            $newService = New Service();
            $newService -> nome = $service;
            $newService -> save();
        }
    }
}
