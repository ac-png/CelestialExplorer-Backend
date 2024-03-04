<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ObservationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'version' => '1.0.0',
            'author' => 'Alice Corry'
        ];
    }
}
