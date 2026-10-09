<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripDestinations;
use App\Http\Resources\DestinationResource;
use App\Http\Resources\TripDestinationResource;
use App\Models\Destination;
use App\Models\TripDestination;
use Illuminate\Http\Request;

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
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $search = trim($request->input('search', ''));

        $query = TripDestination::where('recommendations', true)
            ->with([
                'trip',
                'destination.place.country',
            ]);

        if ($search !== '') {
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

        return response()->json($query->get());
    }

    // 2. Filtrēšana pēc kategorijas
    public function filterByCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|in:rest,nature,adventure',
        ]);

        $category = $request->input('category');

        $recommendations = TripDestination::where('recommendations', true)
            ->whereHas('trip', function ($tripQuery) use ($category) {
                $tripQuery->where('category', $category);
            })
            ->with([
                'trip',
                'destination.place.country',
            ])
            ->get();

        return response()->json($recommendations);
    }

    // 3. Filtrēšana pēc statusa — tikai autorizētiem lietotājiem
    public function filterByStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:visited,unvisited',
            'search' => 'nullable|string|max:255',
            'category' => 'nullable|in:rest,nature,adventure',
        ]);

        $userId = $request->user()->id;
        $status = $request->input('status');
        $search = trim($request->input('search', ''));
        $category = $request->input('category');

        $query = TripDestination::where('recommendations', true)
            ->whereHas('trip', function ($tripQuery) use ($userId, $status, $category) {
                $tripQuery
                    ->where('user_id', $userId)
                    ->where('status', $status);

                if ($category !== null) {
                    $tripQuery->where('category', $category);
                }
            })
            ->with([
                'trip',
                'destination.place.country',
            ]);

        if ($search !== '') {
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

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TripDestinations $request)
    {
        $tripDestination = TripDestination::create(
            $request->validated()
        );

        return response()->json([
            'message' => 'Trip destination created successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tripDestination = TripDestination::with([
            'trip',
            'destination.place.country',
        ])
            ->where('destination_id', $id)
            ->firstOrFail();

        return response()->json($tripDestination);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TripDestinations $request, string $id)
    {
        $tripDestination = TripDestination::findOrFail($id);

        $tripDestination->update($request->validated());

        return new TripDestinationResource($tripDestination);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
