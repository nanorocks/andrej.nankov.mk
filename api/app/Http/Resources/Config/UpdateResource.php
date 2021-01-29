<?php

namespace App\Http\Resources\Config;

use Illuminate\Http\Resources\Json\JsonResource;

class UpdateResource extends JsonResource
{
    public function toArray($request)
    {
        if (is_null($this->resource)) {
            return [
                'code' => 404,
                'data' => [],
                'message' => "No resources for update action!"
            ];
        }

        return is_array($this->resource) ? $this->resource : [
            'code' => 200,
            'data' => $this->resource,
            'message' => 'Successfully updated config!'
        ];
    }
}
