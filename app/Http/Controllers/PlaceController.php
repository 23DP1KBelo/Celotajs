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
}
