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
