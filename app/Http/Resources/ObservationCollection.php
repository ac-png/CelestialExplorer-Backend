<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class ObservationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $user = Auth::user();

        $filteredObservations = $this->collection->filter(function ($observation) use ($user) {
            return $observation->user_id === $user->id;
        });

        if ($filteredObservations->isEmpty()) {
            return [
                'message' => 'No observations found!',
                'version' => '1.0.0',
                'author' => 'Alice Corry'
            ];
        }

        return [
            'data' => $filteredObservations,
            'version' => '1.0.0',
            'author' => 'Alice Corry'
        ];
    }
}
