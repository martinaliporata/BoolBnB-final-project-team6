<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'surname' => 'Admin',
            'birth_date' => '1980-01-01', // Sostituisci con la data di nascita desiderata
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);
    }
}