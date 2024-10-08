<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'Img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
    public function show(string $id)
    {
        $apartment = Apartment::with("views", "sponsorships", "services", "messages")->findOrFail($id);

        // Aggiungi l'URL completo per l'immagine
        $apartment->Img = filter_var($apartment->Img, FILTER_VALIDATE_URL ) ? $apartment->Img : asset('http://127.0.0.1:8000/storage/images_apartment/' . $apartment->Img);

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
            $apartment->Img = $apartment->Img;
            return response()->json($apartment);
        } else {
            return response()->json(['message' => 'Apartment not found'], 404);
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

    public function search(Request $request)
    {
        // Validazione dei parametri di ricerca
        $validated = $request->validate([
            'Latitudine' => 'required|numeric',
            'Longitudine' => 'required|numeric',
            'radius' => 'nullable|integer|min:1|max:20',  // Il raggio può essere omesso e deve essere tra 1 e 20 km
            'Stanze' => 'nullable|integer',
            'Letti' => 'nullable|integer',
            'Bagni' => 'nullable|integer',
            'Prezzo' => 'nullable|numeric',
            'services' => 'nullable|array',
        ]);

        // Abilita log delle query
        DB::enableQueryLog();

        // Ottieni latitudine e longitudine
        $latitudine = $validated['Latitudine'];
        $longitudine = $validated['Longitudine'];

        Log::info('Coordinate ottenute', [
            'Latitudine' => $latitudine,
            'Longitudine' => $longitudine
        ]);

        $radius = $validated['radius'] ?? 20; // km
        $raggioInMetri = $radius * 1000; // Converti in metri
        Log::info('Raggio di ricerca', ['radius' => $radius, 'raggioInMetri' => $raggioInMetri]);

        $query = Apartment::query();

        // Calcolo della distanza utilizzando ST_Distance_Sphere
        $query->selectRaw(
            "*, ST_Distance_Sphere(POINT(Longitudine, Latitudine), POINT(?, ?)) AS distance",
            [$longitudine, $latitudine]
        )
        ->whereRaw(
            "ST_Distance_Sphere(POINT(Longitudine, Latitudine), POINT(?, ?)) <= ?",
            [$longitudine, $latitudine, $raggioInMetri]
        );

        // Applica filtri aggiuntivi se presenti
        if ($validated['Stanze'] ?? false) {
            $query->where('Stanze', '>=', $validated['Stanze']);
        }
        if ($validated['Letti'] ?? false) {
            $query->where('Letti', '>=', $validated['Letti']);
        }
        if ($validated['Bagni'] ?? false) {
            $query->where('Bagni', '>=', $validated['Bagni']);
        }
        if ($validated['Prezzo'] ?? false) {
            $query->where('Prezzo', '<=', $validated['Prezzo']);
        }
        if ($validated['services'] ?? false) {
            $services = $validated['services'];
            $query->whereHas('services', function ($q) use ($services) {
                $q->whereIn('id', $services);
            });
        }

        // Esegui la query con i servizi caricati, ordinando per distanza
        $apartments = $query->with('services')->orderBy('distance')->get();

        // Aggiungi l'URL completo dell'immagine agli appartamenti
        $apartments->each(function ($apartment) {
            $apartment->Img = filter_var($apartment->Img, FILTER_VALIDATE_URL ) ? $apartment->Img : asset('http://127.0.0.1:8000/storage/images_apartment/' . $apartment->Img);
        });

        // Log dei risultati
        Log::info('Query Eseguita', DB::getQueryLog());
        Log::info('Risultati trovati', ['count' => $apartments->count()]);

        // Restituisci il risultato in formato JSON
        return response()->json($apartments);
    }


}














