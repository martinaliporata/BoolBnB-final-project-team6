<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData=[[
            'name' => 'Luca',
            'surname' => 'Rossi',
            'birth_date' => '1990-04-25',
            'email' => 'luca.rossi@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Giulia',
            'surname' => 'Bianchi',
            'birth_date' => '1985-08-17',
            'email' => 'giulia.bianchi@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password456'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Marco',
            'surname' => 'Verdi',
            'birth_date' => '1995-12-02',
            'email' => 'marco.verdi@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password789'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),


        ]
        ];

        foreach($userData as $user){
            $newUser=new User();
            $newUser->name = $user['name'];
            $newUser->surname = $user['surname'];
            $newUser->birth_date = $user['birth_date'];
            $newUser->email = $user['email'];
            $newUser->email_verified_at = $user['email_verified_at'];
            $newUser->password = $user['password'];
            $newUser->save();
        };
    }
}
