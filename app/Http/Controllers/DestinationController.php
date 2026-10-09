<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Http\Resources\DestinationResource;
use App\Http\Requests\DestinationRequest;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = Destination::with('place')->get();
        return DestinationResource::collection($destinations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DestinationRequest $request)
    {
        $destination = Destination::create($request->validated());

        return response()->json([
            'message' => 'Destination created successfully.',
            'data' => new DestinationResource($destination),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $destination = Destination::with('place')->findOrFail($id);
        return new DestinationResource($destination);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DestinationRequest $request, string $id)
    {
        $destination = Destination::findOrFail($id);

        $destination->update($request->validated());

        $destination->load('place');

        return new DestinationResource($destination);
    }
}
