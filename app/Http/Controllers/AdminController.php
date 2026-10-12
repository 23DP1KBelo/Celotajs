<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestinationRequest;
use App\Http\Resources\DestinationResource;
use App\Http\Resources\UserResource;
use App\Models\Destination;
use App\Models\TripDestination;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Visi lietotāji (ar meklēšanu pēc lietotājvārda vai e-pasta).
     */
    public function users(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $search = trim($request->input('search', ''));

        $users = User::withCount('trips')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('Username', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->orderBy('id')
            ->get();

        return response()->json([
            'data' => $users->map(fn (User $user) => [
                ...(new UserResource($user))->resolve($request),
                'trips_count' => $user->trips_count,
            ]),
        ]);
    }

    /**
     * Lietotāja lomas maiņa (user / admin).
     */
    public function updateUserRole(Request $request, string $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ], [
            'role.required' => 'Loma ir obligāta.',
            'role.in' => 'Lomai jābūt "user" vai "admin".',
        ]);

        $user = User::findOrFail($id);

        if ($user->id === $request->user()->id) {
            return response()->json([
                'message' => 'Savu lomu mainīt nevar.',
            ], 422);
        }

        $user->role = $request->role;
        $user->save();

        return response()->json([
            'message' => 'Loma nomainīta.',
            'user' => new UserResource($user),
        ]);
    }

    /**
     * Lietotāja dzēšana (kopā ar viņa ceļojumiem un tokeniem).
     */
    public function destroyUser(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === $request->user()->id) {
            return response()->json([
                'message' => 'Savu kontu no administrācijas paneļa dzēst nevar.',
            ], 422);
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'message' => 'Lietotājs izdzēsts.',
        ]);
    }

    /**
     * Visi galamērķi ar vietu, valsti un ieteikumu skaitu.
     */
    public function destinations(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $search = trim($request->input('search', ''));

        $destinations = Destination::with('place.country')
            ->withCount([
                'tripDestinations',
                'tripDestinations as recommended_count' => function ($query) {
                    $query->where('recommendations', true);
                },
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhereHas('place', function ($placeQuery) use ($search) {
                        $placeQuery->where('name', 'LIKE', "%{$search}%")
                            ->orWhereHas('country', function ($countryQuery) use ($search) {
                                $countryQuery->where('name', 'LIKE', "%{$search}%");
                            });
                    });
            })
            ->orderBy('id')
            ->get();

        return response()->json([
            'data' => $destinations->map(fn (Destination $destination) => [
                ...(new DestinationResource($destination))->resolve($request),
                'trips_count' => $destination->trip_destinations_count,
                'recommended' => $destination->recommended_count > 0,
            ]),
        ]);
    }

    /**
     * Galamērķa labošana.
     */
    public function updateDestination(DestinationRequest $request, string $id)
    {
        $destination = Destination::findOrFail($id);

        $destination->update($request->validated());

        $destination->load('place.country');

        return response()->json([
            'message' => 'Galamērķis atjaunināts.',
            'data' => new DestinationResource($destination),
        ]);
    }

    /**
     * Ieteikuma ieslēgšana / izslēgšana (parādās Discover lapā).
     */
    public function recommendDestination(Request $request, string $id)
    {
        $request->validate([
            'recommended' => 'required|boolean',
        ]);

        $destination = Destination::findOrFail($id);

        if (!$destination->tripDestinations()->exists()) {
            return response()->json([
                'message' => 'Galamērķis nav pievienots nevienam ceļojumam, tāpēc to nevar ieteikt.',
            ], 422);
        }

        $destination->tripDestinations()->update([
            'recommendations' => $request->boolean('recommended'),
        ]);

        return response()->json([
            'message' => 'Ieteikums atjaunināts.',
        ]);
    }

    /**
     * Galamērķa dzēšana (kopā ar saitēm uz ceļojumiem).
     */
    public function destroyDestination(string $id)
    {
        $destination = Destination::findOrFail($id);

        TripDestination::where('destination_id', $destination->id)->delete();
        $destination->delete();

        return response()->json([
            'message' => 'Galamērķis izdzēsts.',
        ]);
    }
}
