<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Http\Resources\CountryResource;

class CountryController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $search = trim($request->input('search', ''));

        $countries = Country::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('country_code', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->get();

        return CountryResource::collection($countries);
    }

}
