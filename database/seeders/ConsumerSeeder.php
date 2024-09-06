<?php

namespace Database\Seeders;

use App\Models\Consumer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ConsumerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consumerDatas=[[
            'nome' => 'Luca',
            'cognome' => 'Rossi',
            'data_di_nascita' => '1990-04-25',
            'email' => 'luca.rossi@example.com',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nome' => 'Giulia',
            'cognome' => 'Bianchi',
            'data_di_nascita' => '1985-08-17',
            'email' => 'giulia.bianchi@example.com',
            'password' => Hash::make('password456'),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nome' => 'Marco',
            'cognome' => 'Verdi',
            'data_di_nascita' => '1995-12-02',
            'email' => 'marco.verdi@example.com',
            'password' => Hash::make('password789'),
            'created_at' => now(),
            'updated_at' => now(),


        ]
        ];

        foreach($consumerDatas as $consumerData){
            $newConsumer=new Consumer();
            $newConsumer->nome = $consumerData['nome'];
            $newConsumer->cognome = $consumerData['cognome'];
            $newConsumer->data_di_nascita = $consumerData['data_di_nascita'];
            $newConsumer->email = $consumerData['email'];
            $newConsumer->password = $consumerData['password'];
            $newConsumer->save();
        };



    }
}


