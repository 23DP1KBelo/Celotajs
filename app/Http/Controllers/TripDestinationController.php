<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TripDestination;

class TripDestinationController extends Controller
{

    public function recommendations()
    {
        $recommendations = TripDestination::where('recommendations', true)
            ->with('destination.place.country')
            ->get();

        return response()->json($recommendations);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
