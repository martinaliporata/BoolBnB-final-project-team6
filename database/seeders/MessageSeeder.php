<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messagesData = [
            [
                'Mail' => 'user1@example.com',
                'Testo' => 'Messaggio per appartamento 1.',
            ],
            [
                'Mail' => 'user2@example.com',
                'Testo' => 'Messaggio per appartamento 2.',
            ],
            [
                'Mail' => 'user3@example.com',
                'Testo' => 'Messaggio per appartamento 3.',
            ],
            [
                'Mail' => 'user4@example.com',
                'Testo' => 'Altro messaggio per appartamento 1.',
            ],
            [
                'Mail' => 'user5@example.com',
                'Testo' => 'Secondo messaggio per appartamento 2.',
            ],
            [
                'Mail' => 'user6@example.com',
                'Testo' => 'Messaggio alternativo per appartamento 3.',
            ],
            [
                'Mail' => 'user7@example.com',
                'Testo' => 'Messaggio per appartamento 4.',
            ],
            [
                'Mail' => 'user8@example.com',
                'Testo' => 'Messaggio per appartamento 5.',
            ],
            [
                'Mail' => 'user9@example.com',
                'Testo' => 'Altro messaggio per appartamento 4.',
            ],
            [
                'Mail' => 'user10@example.com',
                'Testo' => 'Secondo messaggio per appartamento 5.',
            ]
        ];

        foreach($messagesData as $message) {
            $newMessage = New Message();
            $newMessage -> mail = $message['Mail'];
            $newMessage -> testo = $message['Testo'];
            $newMessage -> save();
        }
    }
}
