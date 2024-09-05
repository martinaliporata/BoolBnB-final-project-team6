<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Expr\New_;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsorshipsData = [
            [
                'Durata' => 24,
                'Prezzo' => 2.99,
                'Descrizione' => 'Sponsorizzazione base per una giorno',
            ],
            [
                'Durata' => 72,
                'Prezzo' => 5.99,
                'Descrizione' => 'Sponsorizzazione intermedia per tre giorni',
            ],
            [
                'Durata' => 144,
                'Prezzo' => 9.99,
                'Descrizione' => 'Sponsorizzazione avanzata per sei giorni',
            ],
        ];

        foreach($sponsorshipsData as $sponsorship) {
            $newSponsorship = New Sponsorship();
            $newSponsorship -> durata = $sponsorship['Durata'];
            $newSponsorship -> prezzo = $sponsorship['Prezzo'];
            $newSponsorship -> descrizione = $sponsorship['Descrizione'];
            $newSponsorship -> save();
        }
    }
}
