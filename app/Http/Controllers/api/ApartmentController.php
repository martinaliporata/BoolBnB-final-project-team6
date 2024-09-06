<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
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
