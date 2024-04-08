<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObservationCollection;
use App\Http\Resources\ObservationResource;
use App\Models\Observation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ObservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ObservationCollection(Observation::all());
    }

    public function indexByBodyAndUser($id)
    {
        return new ObservationCollection(Observation::where([
            ['celestial_body_id', '=', $id],
            ['user_id', '=', Auth::id()],
        ])->get());
    }

    public function indexByUser()
    {
        $observations = Observation::where('user_id', '=', Auth::id())->get();

        if ($observations->isEmpty()) {
            return response()->json(['message' => 'No observations found'], Response::HTTP_NOT_FOUND);
        }

        return new ObservationCollection($observations);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $data = $request->only([
            'celestial_body_id', 'date', 'time', 'sky_conditions', 'description', 'rating', 'latitude', 'longitude'
        ]);

        $data['user_id'] = Auth::id();

        $data['uuid'] = Str::uuid();

        $observation = Observation::create($data);

        return new ObservationResource($observation);
    }

    /**
     * Display the specified resource.
     */
    public function showByUUID($uuid)
    {
        $observation = Observation::where('uuid', $uuid)->firstOrFail();
        return new ObservationResource($observation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateByUUID(Request $request, string $uuid)
    {
        try {
            $observation = Observation::where('uuid', $uuid)->firstOrFail();

            $data = $request->only([
                'celestial_body_id', 'date', 'time', 'sky_conditions', 'description', 'rating', 'latitude', 'longitude'
            ]);

            $observation->update($data);

            return new ObservationResource($observation);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyByUUID($uuid)
    {
        try {
            $observation = Observation::where('uuid', $uuid)->firstOrFail();
            $observation->delete();
            return response()->json(['message' => 'Observation deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
