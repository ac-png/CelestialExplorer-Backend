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

    public function indexByBody($id)
    {
        return new ObservationCollection(Observation::where('celestial_body_id', $id)->get());
    }

    public function indexByBodyAndUser($id)
    {
        return new ObservationCollection(Observation::where([
            ['celestial_body_id', '=', $id],
            ['user_id', '=', Auth::id()],
        ])->get());
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $data = $request->only([
            'celestial_body_id', 'date', 'time', 'sky_conditions', 'description', 'rating'
        ]);

        $data['user_id'] = Auth::id();
        $data['location_id'] = 4;
        // $data['date'] = date('Y-m-d', strtotime($data['date']));
        // $data['time'] = date('H:i:s', strtotime($data['time']));


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
    public function updateByUUID(Request $request, string $id)
    {
        //
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
