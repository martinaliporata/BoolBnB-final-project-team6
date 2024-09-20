<?php

namespace App\Http\Controllers;
use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
    // HomeController.php



    public function index()
    {
        // Recupera gli appartamenti associati all'utente autenticato
        $apartments = Apartment::where('user_id', Auth::id())->get();

        // Conta i messaggi non letti degli appartamenti dell'utente
        $unreadMessagesCount = Message::whereHas('apartment', function ($query) {
            $query->where('user_id', Auth::id());
        })->where('is_read', false)->count();

        // Passa i dati alla vista
        return view('home', compact('apartments', 'unreadMessagesCount'));
    }

    public function myapp()
    {
         // Filtra gli appartamenti creati dall'utente autenticato
        $apartments = Apartment::where('user_id', Auth::id())->get();

        return view('UserAppartments', compact('apartments'));
    }

       // ProfileController.php

        public function update(Request $request)
        {
            $request->validate([
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user = Auth::user();

            try {
                if ($request->hasFile('profile_photo')) {
                    // Rimuovi la vecchia foto se esiste
                    if ($user->profile_photo) {
                        Storage::delete('public/profile_photos/' . $user->profile_photo);
                    }

                    // Carica la nuova foto
                    $file = $request->file('profile_photo');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/profile_photos', $filename);

                    // Aggiorna il percorso della foto nel database
                    $user->profile_photo = $filename;
                    $user->save();
                }
            } catch (\Exception $e) {
                Log::error('Error updating profile photo: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Si è verificato un errore durante l\'aggiornamento della foto del profilo.');
            }

            return redirect()->back()->with('status', 'Foto del profilo aggiornata con successo!');
        }

}
