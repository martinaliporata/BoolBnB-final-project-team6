<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){

        $apartments = Apartment::all();

        return response()->json([
            'success' => true,
            'results' => $apartments
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        // Validazione dell'indirizzo
        $request->validate([
            'Indirizzo' => 'required|string',
            'Stanze' => 'required|integer',
            'Letti' => 'required|integer',
            'Bagni' => 'required|integer',
            'Metri_quadrati' => 'required|integer',
            'Img' => 'required|string',
            'Visibilità' => 'required|boolean',
        ]);

        // Ottieni l'indirizzo dal form
        $indirizzo = $request->input('Indirizzo');

        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $indirizzo,
            'key' => env('GOOGLE_API_KEY')  // Usa la chiave API di Google dal file .env
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Verifica se ci sono risultati per la latitudine e longitudine
            if (!empty($data['results'])) {
                $latitudine = $data['results'][0]['position']['lat'];
                $longitudine = $data['results'][0]['position']['lon'];

                // Crea un nuovo appartamento con i dati inclusi latitudine e longitudine
                $apartment = Apartment::create([
                    'Stanze' => $request->input('Stanze'),
                    'Letti' => $request->input('Letti'),
                    'Bagni' => $request->input('Bagni'),
                    'Metri_quadrati' => $request->input('Metri_quadrati'),
                    'Indirizzo' => $indirizzo,
                    'Latitudine' => $latitudine,
                    'Longitudine' => $longitudine,
                    'Img' => $request->input('Img'),
                    'Visibilità' => $request->input('Visibilità'),
                ]);

                // Ritorna una risposta JSON con i dettagli dell'appartamento
                return response()->json($apartment, 201);
            } else {
                return response()->json(['message' => 'Impossibile trovare la latitudine e longitudine per questo indirizzo.'], 400);
            }
        } else {
            return response()->json(['message' => 'Errore nella richiesta all\'API di TomTom.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id){

        $apartment = Apartment::with( "views", "sponsorships", "services","messages" )->findOrFail($id);

        return response()->json([
            'success' => true,
            'results' => $apartment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id){
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
        // Validazione dei parametri di ricerca
        $request->validate([
            'indirizzo' => 'required|string',
            'radius' => 'nullable|integer|min:1|max:20',  // Il raggio può essere omesso e deve essere tra 1 e 20 km
            'Stanze' => 'nullable|integer',
            'Letti' => 'nullable|integer',
            'Bagni' => 'nullable|integer',
            'Prezzo' => 'nullable|numeric',
            'services' => 'nullable|array',
        ]);

        // Ottieni l'indirizzo e usa TomTom per trovare latitudine e longitudine
        $indirizzo = $request->input('indirizzo');
        $radius = $request->input('radius', 20);  // Usa 20 km come valore predefinito

        // Effettua una richiesta all'API di TomTom per ottenere latitudine e longitudine
        $response = Http::withOptions(['verify' => false])
            ->get('https://api.tomtom.com/search/2/geocode/'.urlencode($indirizzo).'.json', [
                'key' => env('TOMTOM_API_KEY'),

            ]);

        if ($response->successful()) {
            $data = $response->json();

            if (!empty($data['results'])) {
                $latitudine = $data['results'][0]['position']['lat'];
                $longitudine = $data['results'][0]['position']['lon'];

                // Verifica che latitudine e longitudine siano valide
                if (!isset($latitudine, $longitudine)) {
                    return response()->json(['message' => 'Latitudine o longitudine non valide.'], 400);
                }

                // Crea una query per trovare gli appartamenti nel raggio specificato
                $query = Apartment::query();

                // Aggiungi filtri opzionali
                if ($request->has('Stanze')) {
                    $query->where('Stanze', $request->input('Stanze'));
                }
                if ($request->has('Letti')) {
                    $query->where('Letti', $request->input('Letti'));
                }
                if ($request->has('Bagni')) {
                    $query->where('Bagni', $request->input('Bagni'));
                }
                if ($request->has('Prezzo')) {
                    $query->where('Prezzo', '<=', $request->input('Prezzo'));
                }
                if ($request->has('services')) {
                    $services = $request->input('services');
                    $query->whereHas('services', function ($q) use ($services) {
                        $q->whereIn('id', $services);
                    });
                }

                // Utilizza la formula Haversine per trovare gli appartamenti nel raggio specificato
                $haversine = "(6371 * acos(cos(radians($latitudine))
                               * cos(radians(Latitudine))
                               * cos(radians(Longitudine) - radians($longitudine))
                               + sin(radians($latitudine))
                               * sin(radians(Latitudine))))";

                // Filtra gli appartamenti in base al raggio (in km)
                $apartments = $query->havingRaw("$haversine <= ?", [$radius])
                                    ->get();

                return response()->json($apartments);
            } else {
                return response()->json(['message' => 'Impossibile trovare la latitudine e longitudine per questo indirizzo.'], 400);
            }
        } else {
            return response()->json(['message' => 'Errore nella richiesta all\'API di TomTom.'], 500);
        }
    }







    public function updateSponsorship(Request $request, $apartmentId){
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







