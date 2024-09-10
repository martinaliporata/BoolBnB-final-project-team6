<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function storeView(Request $request, $apartmentId)
    {
        // Trova l'appartamento o ritorna un errore 404 se non esiste
        $apartment = Apartment::findOrFail($apartmentId);

        // Ottieni l'indirizzo IP dell'utente
        $ipAddress = $request->ip();

        // Verifica se esiste già una visualizzazione per questo IP e appartamento nelle ultime 24 ore
        $existingView = View::where('apartment_id', $apartmentId)
                            ->where('ip_address', $ipAddress)
                            ->where('created_at', '>=', Carbon::now()->subDay()) // Solo nelle ultime 24 ore
                            ->first();

        if (!$existingView) {
            // Se non esiste una visualizzazione recente, creane una nuova
            View::create([
                'ip_address' => $ipAddress,
                'apartment_id' => $apartmentId,
            ]);
        }


        // Conta tutte le visualizzazioni uniche per l'appartamento nelle ultime 24 ore
        $viewCount = View::where('apartment_id', $apartmentId)
                        ->where('created_at', '>=', Carbon::now()->subDay()) // Solo nelle ultime 24 ore
                        ->count();

        // Ritorna il conteggio delle visualizzazioni
        return response()->json([
            'message' => 'Visualizzazione registrata con successo.',
            'apartment_id' => $apartmentId,
            'ip_address' => $ipAddress,
            'view_count' => $viewCount,
        ], 201);
    }
}
