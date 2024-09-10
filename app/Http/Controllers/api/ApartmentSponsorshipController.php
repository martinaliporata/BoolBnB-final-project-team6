<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApartmentSponsorshipController extends Controller
{
    public function store(Request $request)
    {
        // Validazione dei dati
        $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'sponsorship_id' => 'required|exists:sponsorships,id',
        ]);

        // Ottieni l'appartamento e la sponsorship dal database
        $apartment = Apartment::findOrFail($request->apartment_id);
        $sponsorship = Sponsorship::findOrFail($request->sponsorship_id);

        // Calcola la durata in base all'ID della sponsorship
        $duration = match ($sponsorship->id) {
            1 => 24,  // ID 1: 24 ore
            2 => 72,  // ID 2: 72 ore
            3 => 144, // ID 3: 144 ore
            default => 24, // Default: 24 ore
        };

        // Ottieni l'ultima sponsorship attiva per questo appartamento
        $lastSponsorship = DB::table('apartment_sponsorship')
            ->where('apartment_id', $apartment->id)
            ->orderBy('end_date', 'desc')
            ->first();

        // Se esiste un'ultima sponsorship attiva, inizia la nuova sponsorship alla fine di quella
        if ($lastSponsorship && $lastSponsorship->end_date > now()) {
            $startDate = Carbon::parse($lastSponsorship->end_date);
        } else {
            // Altrimenti, inizia la nuova sponsorship ora
            $startDate = now();
        }

        // Calcola la data di fine in base alla durata
        $endDate = (clone $startDate)->addHours($duration);

        // Inserisci il record nella tabella pivot
        DB::table('apartment_sponsorship')->insert([
            'apartment_id' => $apartment->id,
            'sponsorship_id' => $sponsorship->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        // Ritorna una risposta JSON di successo
        return response()->json([
            'message' => 'Sponsorship associata con successo all\'appartamento.',
            'apartment_id' => $apartment->id,
            'sponsorship_id' => $sponsorship->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ], 201);
    }
}
