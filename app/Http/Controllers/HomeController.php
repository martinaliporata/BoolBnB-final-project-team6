<?php

namespace App\Http\Controllers;
use App\Models\Apartment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         // Filtra gli appartamenti creati dall'utente autenticato
        $apartments = Apartment::where('user_id', Auth::id())->get();

        return view('home', compact('apartments'));
    }

    public function myapp()
    {
         // Filtra gli appartamenti creati dall'utente autenticato
        $apartments = Apartment::where('user_id', Auth::id())->get();

        return view('UserAppartments', compact('apartments'));
    }

        public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validazione del file immagine
        $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Se è stata caricata una nuova immagine
        if ($request->hasFile('profile_photo')) {
            // Rimuovi la vecchia immagine se esiste
            if ($user->profile_photo) {
                Storage::delete('public/profile_photos/' . $user->profile_photo);
            }

            // Salva la nuova immagine
            $fileName = time() . '.' . $request->profile_photo->extension();
            $request->profile_photo->storeAs('public/profile_photos', $fileName);

            // Aggiorna l'utente con il nuovo nome dell'immagine
            $user->profile_photo = $fileName;
        }


        $user->save();

        return redirect()->back()->with('success', 'Profilo aggiornato con successo');
    }

}
