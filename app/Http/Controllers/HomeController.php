<?php

namespace App\Http\Controllers;
use App\Models\Apartment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index()
    {
         // Filtra gli appartamenti creati dall'utente autenticato
        $apartments = Apartment::where('user_id', Auth::id())->get();

        return view('home', compact('apartments'));
    }

    public function myapp()
    {
         // Filtra gli appartamenti creati dall'utente autenticato
        $apartments = Apartment::where('user_id', Auth::id())->get();

        return view('UserAppartments', compact('apartments'));
    }
}
