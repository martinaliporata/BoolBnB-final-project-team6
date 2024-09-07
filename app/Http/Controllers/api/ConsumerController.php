<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Consumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ConsumerController extends Controller
{
    public function register(Request $request)
    {
        // Validazione dei dati in input
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'data_di_nascita' => 'required|date',
            'email' => 'required|string|email|max:255|unique:consumers,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Creazione del nuovo Consumer con hashing della password
        $consumer = Consumer::create([
            'nome' => $request->nome,
            'cognome' => $request->cognome,
            'data_di_nascita' => $request->data_di_nascita,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash della password
        ]);

        // Ritorna la risposta JSON con i dati dell'utente
        return response()->json([
            'message' => 'Registrazione avvenuta con successo.',
            'consumer' => $consumer,
        ], 201);
    }
}
