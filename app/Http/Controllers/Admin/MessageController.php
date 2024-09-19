<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        // Recupera tutti i messaggi dell'utente autenticato
        $messages = Message::where('apartment_id', Auth::id())->get();

        return view('admin.messages.index', compact('messages'));
    }

    public function show($id)
    {
        // Trova il messaggio tramite l'id
        $message = Message::findOrFail($id);

        // Controlla se il messaggio appartiene all'utente autenticato (opzionale)
        if ($message->user_id != Auth::id()) {
            abort(403, 'Accesso negato');
        }

        // Segna il messaggio come letto se non è già stato letto
        if (!$message->is_read) {
            $message->is_read = true;
            $message->save();
        }

        // Restituisci la vista con i dettagli del messaggio
        return view('messages.show', compact('message'));
    }


}
