<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TripRequest;
use App\Models\Trip;
use App\Models\TripDestination;
use App\Http\Resources\TripResource;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = Trip::with(['destinations', 'destinations.place', 'destinations.place.country'])->get();
        return response()->json($trips);
    }

    public function filterRecommendations(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'in:rest,nature,adventure'],
            'status' => ['nullable', 'in:visited,unvisited'],
        ]);

        $user = $request->user();

        $query = TripDestination::query()
            ->where('recommendations', true)
            ->with(['destination.place.country', 'trip']);

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->whereHas('destination', function ($destinationQuery) use ($search) {
                $destinationQuery
                    ->where('title', 'LIKE', "%{$search}%")
                    ->orWhereHas('place', function ($placeQuery) use ($search) {
                        $placeQuery
                            ->where('name', 'LIKE', "%{$search}%")
                            ->orWhereHas('country', function ($countryQuery) use ($search) {
                                $countryQuery->where('name', 'LIKE', "%{$search}%");
                            });
                    });
            });
        }

        if ($request->filled('category')) {
            $category = $request->input('category');

            $query->whereHas('trip', function ($tripQuery) use ($category, $user) {
                $tripQuery
                    ->where('user_id', $user->id)
                    ->where('category', $category);
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');

            $query->whereHas('trip', function ($tripQuery) use ($status, $user) {
                $tripQuery
                    ->where('user_id', $user->id)
                    ->where('status', $status);
            });
        }

        return response()->json($query->get());
    }

    // Get all trips for the authenticated user with their destinations
    public function getUserTripsWithDestinations(Request $request)
    {
        $trips = Trip::with([
            'tripDestinations.destination.place.country',
        ])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return TripResource::collection($trips);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TripRequest $request)
    {
        $validated = $request->validated();

        $trip = Trip::create($validated);
        return response()->json($trip, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trip = Trip::findOrFail($id);

        return new TripResource($trip);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TripRequest $request, string $id)
    {
        $trip = Trip::findOrFail($id);

        $trip->update($request->validated());

        return new TripResource($trip);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trip = Trip::findOrFail($id);

        TripDestination::where('trip_id', $trip->id)->delete();

        $trip->delete();

        return response()->json([
            'message' => 'Trip and related destinations deleted successfully.'
        ], 200);
    }
}
