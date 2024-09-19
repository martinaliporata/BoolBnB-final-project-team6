<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use App\Models\Message;
use App\Models\Service;
use App\Models\Sponsorship;
use App\Models\User;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::all();
        return view('admin.apartments.index', compact('apartments'));
    }


    public function __construct()
    {
        // Applica il middleware auth a tutte le azioni del controller
        $this->middleware('auth')->only('create', 'edit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $views = View::all();
        $messages = Message::all();
        $services = Service::all();
        $sponsorships = Sponsorship::all();
        return view('admin.apartments.create', compact('users', 'views', 'messages', 'services', 'sponsorships'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validazione dell'indirizzo
        $request->validate([
            'Nome' => 'required|string|max:25',
            'Stanze' => 'required|integer|min:1',
            'Letti' => 'required|integer|min:1',
            'Bagni' => 'required|integer|min:1',
            'Metri_quadrati' => 'required|integer|min:10',
            'Prezzo' => 'required|integer|min:20',
            'Indirizzo' => 'required|string|max:255',
            'Img' => 'required|string|max:255',
            'services' => 'array|exists:services,id',
        ]);

        // Ottieni l'indirizzo dal form
        $indirizzo = $request->input('Indirizzo');

        // Effettua una richiesta all'API di TomTom per ottenere latitudine e longitudine
        $response = Http::withOptions(['verify' => false])
            ->get('https://api.tomtom.com/search/2/geocode/' . urlencode($indirizzo) . '.json', [
                'key' => env('TOMTOM_API_KEY'),
                'limit' => 1
            ]);

        if ($response->successful()) {
            $data = $response->json();

            // Verifica se ci sono risultati per la latitudine e longitudine
            if (!empty($data['results'])) {
                $latitudine = $data['results'][0]['position']['lat'];
                $longitudine = $data['results'][0]['position']['lon'];

                // Crea un nuovo appartamento con i dati inclusi latitudine e longitudine
                $apartment = Apartment::create([
                    'user_id' => Auth::user()->id,
                    'Nome' => $request->input('Nome'),
                    'Stanze' => $request->input('Stanze'),
                    'Letti' => $request->input('Letti'),
                    'Bagni' => $request->input('Bagni'),
                    'Metri_quadrati' => $request->input('Metri_quadrati'),
                    'Prezzo' => $request->input('Prezzo'),
                    'Indirizzo' => $indirizzo,
                    'Latitudine' => $latitudine,
                    'Longitudine' => $longitudine,
                    'Img' => $request->input('Img'),
                    'Visibilità' => $request->input('Visibilità'),
                ]);

                // Associazione dei servizi
                if ($request->has('services')) {
                    $apartment->services()->sync($request->services);
                }

                // Reindirizza alla pagina di dettaglio dell'appartamento con un messaggio di successo
                return redirect()->route('apartments.show', $apartment->id)->with('success', 'Appartamento creato con successo.');
            } else {
                // Reindirizza alla pagina precedente con un errore
                return redirect()->back()
                    ->withErrors(['Indirizzo' => 'Impossibile trovare la latitudine e longitudine per questo indirizzo.'])
                    ->withInput();
            }
        } else {
            // Reindirizza alla pagina precedente con un errore per la richiesta API
            return redirect()->back()
                ->withErrors(['API' => 'Errore nella richiesta all\'API di TomTom.'])
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        $service = Service::all();
        return view('admin.apartments.show', compact('apartment', 'service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        $users = User::all();
        $views = View::all();
        $messages = Message::all();
        $services = Service::all();
        $sponsorships = Sponsorship::all();
        return view('admin.apartments.edit', compact('apartment', 'users', 'views', 'messages', 'services', 'sponsorships'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        // $data = $request->except('_token');
        $data = $request->validated();
        $apartment->update($data);

        // Associazione dei servizi
        if ($request->has('services')) {
            $apartment->services()->sync($request->services);
        } else {
            // Se nessun servizio è selezionato, deseleziona tutti i servizi
            $apartment->services()->sync([]);
        }

        return redirect()->route('apartments.show', $apartment)->with('update_apartment_message', $apartment->nome . "È stato aggiornato con successo!!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {

        $apartment->delete();

        return redirect()->route('myapp')->with('message_trash', 'Appartamento spostato nel cestino.');
    }

    /**
     * Trash
     * */

    public function deletedIndex()
    {
        $apartments = Apartment::onlyTrashed()->get();

        return view('admin.apartments.delete', compact('apartments'));
    }

    // restore items from the recycle bin

    public function restore(string $id)
    {
        $apartment = Apartment::onlyTrashed()->findOrFail($id);
        $apartment->restore();

        // Reindirizza alla lista degli appartamenti in Vue (sostituisci con l'URL corretto)
        return redirect()->away('/admin/apartments/delete')
            ->with('message_restore', 'Appartamento ripristinato con successo.');
    }

    // Empty the trash
    public function delete(string $id)
    {
        $apartments = Apartment::onlyTrashed()->findOrFail($id);
        $apartments->services()->detach();
        $apartments->forceDelete();
        return redirect()->away('/admin/apartments/delete')
            ->with('message_delete', 'Appartamento eliminato definitivamente.');
    }

    // public function search(Request $request)
    // {

    //     // Prendere i parametri di ricerca dalla richiesta
    //     $stanze = $request->input('Stanze');
    //     $letti = $request->input('Letti');
    //     $persone = $request->input('Persone');
    //     $price = $request->input('Prezzo');
    //     $indirizzo = $request->input('indirizzo');
    //     $services = $request->input('services'); // array di servizi

    //     // Costruire la query dinamicamente in base ai parametri di ricerca forniti
    //     $query = Apartment::query();

    //     if ($stanze) {
    //         $query->where('Stanze', '>=', $stanze);
    //     }

    //     if ($letti) {
    //         $query->where('Letti', '>=', $letti);
    //     }

    //     if ($persone) {
    //         $query->where('num_people', '>=', $persone);
    //     }

    //     if ($price) {
    //         $query->where('Prezzo', '<=', $price);
    //     }

    //     if (!empty($indirizzo)) {
    //         // Utilizza il filtro sull'indirizzo (potrebbe essere necessario migliorare la query)
    //         $query->where('Indirizzo', 'LIKE', '%' . $indirizzo . '%');
    //     }

    //     // Filtrare per servizi se forniti
    //     if ($services && is_array($services)) {
    //         $query->whereHas('services', function ($q) use ($services) {
    //             $q->whereIn('id', $services);
    //         });
    //     }

    //     // Ottenere i risultati della ricerca
    //     $apartments = $query->with(['services', 'sponsorships'])->get();


    //     // Restituire la vista con i risultati
    //     return view('admin.apartments.results', compact('apartments'));

    // }

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
            ->get('https://api.tomtom.com/search/2/geocode/' . urlencode($indirizzo) . '.json', [
                'key' => env('TOMTOM_API_KEY'),
                'limit' => 1
            ]);

        if ($response->successful()) {
            $data = $response->json();

            if (!empty($data['results'])) {
                $latitudine = $data['results'][0]['position']['lat'];
                $longitudine = $data['results'][0]['position']['lon'];

                // Trova gli appartamenti nel raggio specificato
                $apartments = Apartment::whereRaw(
                    "ST_Distance_Sphere(POINT(Longitudine, Latitudine), POINT(?, ?)) <= ?",
                    [$longitudine, $latitudine, $radius * 1000]  // Converti km in metri
                )->get();

                return view('admin.apartments.results', compact('apartments'));
            } else {
                return response()->json(['message' => 'Impossibile trovare la latitudine e longitudine per questo indirizzo.'], 400);
            }
        } else {
            return response()->json(['message' => 'Errore nella richiesta all\'API di TomTom.'], 500);
        };

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
            // Assumendo che tu abbia una relazione con un modello Service
            $query->whereHas('services', function ($q) use ($services) {
                $q->whereIn('id', $services);
            });
        }

        $apartments = $query->get();

        return response()->json($apartments);
    }
}
