<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    public function toArray($request)
    {
        if (is_null($this->resource)) {
            return [
                'code' => 404,
                'data' => [],
                'message' => "No resources for create action!"
            ];
        }

        return is_array($this->resource) ? $this->resource : [
            'code' => 200,
            'data' => $this->resource->toArray(),
            'message' => 'Successfully created post!'
        ];
    }
}
