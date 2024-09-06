<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){

        $apartments = Apartment::with( "views", "sponsorships", "services","messages" )->paginate(10);

        return response()->json([
            'success' => true,
            'results' => $apartments
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $apartment = Apartment::create($request->all());
        return response()->json($apartment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $apartment = Apartment::with( "views", "sponsorships", "services","messages" )->findOrFail($id);

        return response()->json([
            'success' => true,
            'results' => $apartment
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $apartment = Apartment::findOrFail($id);
        if ($apartment) {
            $apartment->update($request->all());
            return response()->json($apartment);
        } else {
            return response()->json(['message' => 'Apartment not found'], 404);
        }
    }
    public function search(Request $request)
    {
        // Prendere i parametri di ricerca dalla richiesta
        $stanze = $request->input('stanze');
        $letti = $request->input('letti');
        $bagni = $request->input('bagni');
        $metriQuadrati = $request->input('metri_quadrati');
        $indirizzo = $request->input('indirizzo');
        $latitudine = $request->input('latitudine');
        $longitudine = $request->input('longitudine');
        $services = $request->input('services'); // array di servizi

        // Costruire la query dinamicamente in base ai parametri di ricerca forniti
        $query = Apartment::query();

        if ($stanze) {
            $query->where('Stanze', $stanze);
        }

        if ($letti) {
            $query->where('Letti', $letti);
        }

        if ($bagni) {
            $query->where('Bagni', $bagni);
        }

        if ($metriQuadrati) {
            $query->where('Metri_quadrati', '>=', $metriQuadrati);
        }

        if ($indirizzo) {
            $query->where('Indirizzo', 'LIKE', "%{$indirizzo}%");
        }

        if ($latitudine && $longitudine) {
            $query->where('Latitudine', $latitudine)
                  ->where('Longitudine', $longitudine);
        }

        // Filtrare per servizi se forniti
        if ($services && is_array($services)) {
            $query->whereHas('services', function($q) use ($services) {
                $q->whereIn('nome', $services);
            });
        }

        // Ottenere i risultati della ricerca
        $results = $query->with(['services', 'sponsorships'])->get();

        // Restituire i risultati in formato JSON
        return response()->json($results);
    }

    public function updateSponsorship(Request $request, $apartmentId)
    {
        // Validazione della richiesta
        $request->validate([
            'sponsorship_id' => 'required|exists:sponsorships,id', // sponsorship_id deve esistere
        ]);

        // Recuperare l'appartamento
        $apartment = Apartment::findOrFail($apartmentId);

        // Recuperare la sponsorship scelta
        $sponsorshipId = $request->input('sponsorship_id');
        $sponsorship = Sponsorship::findOrFail($sponsorshipId);

        // Calcolare la durata in base all'ID della sponsorship
        $durationInHours = match($sponsorshipId) {
            1 => 24,  // ID 1: 24 ore
            2 => 72,  // ID 2: 72 ore
            3 => 144, // ID 3: 144 ore
            default => throw new \Exception("Sponsorship non valida") // In caso di altri ID non previsti
        };

        // Controllare se l'appartamento ha già una sponsorizzazione attiva
        $currentSponsorship = $apartment->sponsorships()
        // si sta cercando una sponsorizzazione dove la data di fine (end_date) è maggiore dell'ora corrente (Carbon::now()), cioè dove la sponsorizzazione non è ancora scaduta - questa linea filtra le sponsorizzazioni dell'appartamento per trovare quelle ancora attive
        ->wherePivot('end_date', '>', Carbon::now())
        // Questo significa che verrà selezionata l'ultima sponsorizzazione attiva in base alla data di scadenza.
        ->latest('pivot_end_date')
        //  In questo caso, seleziona la sponsorizzazione più recente (cioè quella che scade più tardi) tra quelle attive.
        ->first();
        // $currentSponsorship conterrà quindi la sponsorizzazione attiva (se esiste), altrimenti sarà null se nessuna sponsorizzazione è attiva.

        if ($currentSponsorship) {
            // Sponsorizzazione attiva trovata, quindi estendere la durata
            $startDate = Carbon::now(); // Data corrente

            // La nuova data di fine è aggiunta alla fine della sponsorizzazione corrente
            $endDate = Carbon::parse($currentSponsorship->pivot->end_date)->addHours($durationInHours);
        } else {
            // Nessuna sponsorizzazione attiva, quindi creiamo una nuova
            $startDate = Carbon::now(); // Data corrente
            $endDate = $startDate->copy()->addHours($durationInHours); // Aggiungere le ore
        }

        // Aggiornare la sponsorship dell'appartamento
        $apartment->sponsorships()->updateExistingPivot($sponsorship->id, [
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        // Aggiornare o aggiungere la sponsorizzazione dell'appartamento
        $apartment->sponsorships()->syncWithoutDetaching([
            $sponsorship->id => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ]
        ]);

        // Restituire una risposta di successo
        return response()->json([
        'message' => 'Sponsorship aggiornata con successo!',
        'sponsorship_id' => $sponsorshipId,
        'start_date' => $startDate,
        'end_date' => $endDate
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $apartment = Apartment::find($id);
        if ($apartment) {
            $apartment->delete();
            return response()->json(['message' => 'Apartment deleted']);
        } else {
            return response()->json(['message' => 'Apartment not found'], 404);
        }
    }

}







