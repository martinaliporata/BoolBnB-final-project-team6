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

    public function store(StoreApartmentRequest $request)
    {
        $data = $request->except('_token');
        $data = $request->validated();
        $newApartment = new Apartment($data);
        $newApartment->save();

        return redirect()->route('admin.apartments.show', $newApartment)->with('new_apartment_message', $newApartment->name . "È stato creato con successo!!");
    }


    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
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
        return view('admin.apartments.edit', compact('apartment','users', 'views', 'messages', 'services', 'sponsorships'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        //       $data = $request->except('_token');
        $data = $request->validated();
        $apartment->update($data);

        return redirect()->route('admin.apartments.show', $apartment)->with('update_apartment_message', $apartment->nome . "È stato aggiornato con successo!!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {

        $apartment->delete();

        return redirect()->route('apartments.index')->with('message_delete', $apartment->Nome . " it has been successfully deleted!!");
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
        $apartments = Apartment::onlyTrashed()->findOrFail($id);
        $apartments->restore();

        return redirect()->route('apartments.index')->with('message_restore', $apartments->Nome . " it has been successfully restored!!");
    }

    // Empty the trash
    public function delete(string $id)
    {
        $apartments = Apartment::onlyTrashed()->findOrFail($id);
        $apartments->services()->detach();
        $apartments->forceDelete();
        return redirect()->route('apartments.deleteindex')->with('message_delete', $apartments->Nome . " The trash has been emptied!!");
    }

    public function search(Request $request)
    {
        // Prendere i parametri di ricerca dalla richiesta
        $stanze = $request->input('numStanze');
        $letti = $request->input('numLetti');
        $persone = $request->input('numPersone');
        $priceMin = $request->input('priceMin');
        $priceMax = $request->input('priceMax');
        $indirizzo = $request->input('city');
        $services = $request->input('services'); // array di servizi

        // Costruire la query dinamicamente in base ai parametri di ricerca forniti
        $query = Apartment::query();

        if ($stanze) {
            $query->where('Stanze', '>=', $stanze);
        }

        if ($letti) {
            $query->where('Letti', '>=', $letti);
        }

        if ($persone) {
            $query->where('num_people', '>=', $persone);
        }

        if ($priceMin && $priceMax) {
            $query->whereBetween('price', [$priceMin, $priceMax]);
        }

        if ($indirizzo) {
            $query->where('Indirizzo', 'LIKE', "%{$indirizzo}%");
        }

        // Filtrare per servizi se forniti
        if ($services && is_array($services)) {
            $query->whereHas('services', function($q) use ($services) {
                $q->whereIn('id', $services);
            });
        }

        // Ottenere i risultati della ricerca
        $apartments = $query->with(['services', 'sponsorships'])->get();

        $servizi= Service::all();
        // Restituire la vista con i risultati
        return view('admin.apartments.results', compact('apartments', 'servizi'));
    }
}
