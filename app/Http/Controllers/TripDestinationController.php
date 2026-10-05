<?php

namespace App\Http\Controllers;

use App\Http\Resources\DestinationResource;
use App\Models\TripDestination;
use Illuminate\Http\Request;
use App\Models\Destination;
use App\Http\Resources\TripDestinations;

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

    public function searchRecommendations(Request $request)
    {
        $search = $request->input('search');

        $recommendations = TripDestination::with([
            'destination.place.country'
        ])
        ->where('recommendations', true)
        ->whereHas('destination', function ($query) use ($search) {

            $query->where('title', 'LIKE', '%' . $search . '%')

                ->orWhereHas('place', function ($query) use ($search) {

                    $query->where('name', 'LIKE', '%' . $search . '%')

                        ->orWhereHas('country', function ($query) use ($search) {
                            $query->where('name', 'LIKE', '%' . $search . '%');
                        });
                });
        })
        ->get();

        return TripDestinations::collection($recommendations);
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
