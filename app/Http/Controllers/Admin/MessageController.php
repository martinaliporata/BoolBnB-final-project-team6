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
        // Recupera tutti gli appartamenti dell'utente autenticato
        $userApartments = Auth::user()->apartments()->pluck('id');

        // Recupera i messaggi associati agli appartamenti dell'utente
        $messages = Message::whereIn('apartment_id', $userApartments)->get();

        // Passa i messaggi alla vista
        return view('admin.messages.index', compact('messages'));
    }
}