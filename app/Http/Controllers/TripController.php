<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TripRequest;
use App\Models\Trip;
use App\Models\TripDestination;
use App\Http\Resources\TripResource;
use Illuminate\Support\Facades\Storage;

class TripController extends Controller
{
    /**
     * Display all trips.
     */
    public function index()
    {
        $trips = Trip::with([
            'destinations',
            'destinations.place',
            'destinations.place.country',
        ])->get();

        return response()->json($trips);
    }

    /**
     * Filter recommended destinations.
     */
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
                                $countryQuery->where(
                                    'name',
                                    'LIKE',
                                    "%{$search}%"
                                );
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

    /**
     * Get authenticated user's trips and destinations.
     */
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
     * Store a new trip with an optional image.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_from' => 'nullable|date',
            'date_till' => 'nullable|date|after_or_equal:date_from',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:unvisited,visited',
            'category' => 'nullable|in:rest,nature,adventure',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Save the uploaded image.
        if ($request->hasFile('image')) {
            $path = $request->file('image')
                ->store('trips', 'public');

            $validated['image'] = asset('storage/' . $path);
        }

        // Assign the trip to the authenticated user.
        $validated['user_id'] = $request->user()->id;

        $trip = Trip::create($validated);

        return response()->json([
            'message' => 'Trip created successfully.',
            'trip' => $trip,
        ], 201);
    }

    /**
     * Display one trip.
     */
    public function show(string $id)
    {
        $trip = Trip::findOrFail($id);

        return new TripResource($trip);
    }

    /**
     * Update a trip and optionally replace its image.
     */
    public function update(TripRequest $request, string $id)
    {
        $trip = Trip::findOrFail($id);

        // Only the trip owner may update it.
        abort_unless(
            $trip->user_id === $request->user()->id,
            403,
            'You are not allowed to update this trip.'
        );

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the previous image if it belongs to our storage.
            $this->deleteTripImage($trip->image);

            // Store the new image.
            $path = $request->file('image')
                ->store('trips', 'public');

           $validated['image'] = asset('storage/' . $path);
        }

        $trip->update($validated);

        return new TripResource($trip->fresh());
    }

    /**
     * Delete a trip, its image, and related destinations.
     */
    public function destroy(Request $request, string $id)
    {
        $trip = Trip::findOrFail($id);

        // Only the trip owner may delete it.
        abort_unless(
            $trip->user_id === $request->user()->id,
            403,
            'You are not allowed to delete this trip.'
        );

        // Delete the image file from storage.
        $this->deleteTripImage($trip->image);

        // Delete related destinations.
        TripDestination::where('trip_id', $trip->id)->delete();

        // Delete the trip itself.
        $trip->delete();

        return response()->json([
            'message' => 'Trip and related destinations deleted successfully.',
        ], 200);
    }

    /**
     * Delete a trip image only if it is in our public trips directory.
     */
    private function deleteTripImage(?string $imageUrl): void
    {
        if (!$imageUrl) {
            return;
        }

        $imagePath = parse_url($imageUrl, PHP_URL_PATH);

        if (
            !$imagePath ||
            !str_starts_with($imagePath, '/storage/trips/')
        ) {
            return;
        }

        $relativePath = substr($imagePath, strlen('/storage/'));

        Storage::disk('public')->delete($relativePath);
    }
}
