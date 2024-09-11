<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApartmentRequest;
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
        $this->middleware('auth')->only('create');
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

        return redirect()->route('admin.apartments.show', $newApartment)->with('new_apartment_message', $newApartment->name . " It was created successfully!!");
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        //
    }
}
