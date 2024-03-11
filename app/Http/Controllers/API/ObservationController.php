<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObservationCollection;
use App\Http\Resources\ObservationResource;
use App\Models\Observation;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ObservationCollection(Observation::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $observation = Observation::create($request->only([
            'user_id', 'location_id', 'celestial_body_id', 'date', 'time', 'sky_conditions', 'description', 'rating'
        ]));

        return new ObservationResource($observation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Observation $observation)
    {
        return new ObservationResource($observation);
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
