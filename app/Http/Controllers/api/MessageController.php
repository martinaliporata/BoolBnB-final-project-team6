<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        // Validare i dati in arrivo
        $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'Mail' => 'required|email|max:50', // campo 'Mail'
            'Testo' => 'required|string',      // campo 'Testo'
        ]);

        // Salvare il messaggio nel database
        Message::create([
            'apartment_id' => $request->apartment_id,
            'Mail' => $request->Mail,
            'Testo' => $request->Testo,
        ]);

        return response()->json(['message' => 'Messaggio inviato con successo!'], 201);
    }
}
