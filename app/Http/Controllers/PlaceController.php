<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use App\Http\Resources\PlaceResource;

class PlaceController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $search = trim($request->input('search', ''));

        $places = Place::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->orderBy('name')
            ->get();

        return PlaceResource::collection($places);
    }

    // all Places
    public function index()
    {
        $places = Place::orderBy('name')->get();
        return PlaceResource::collection($places);
    }

    // place by country
    public function getPlacesByCountry($countryId)
    {
        $places = Place::where('country_id', $countryId)
            ->orderBy('name')
            ->get();

        return PlaceResource::collection($places);
    }


}
