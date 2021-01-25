<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class DestroyResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->resource === 0) {
            return [
                'code' => 404,
                'data' => [],
                'message' => "No resources for delete action!",
            ];
        }

        return [
            'code' => 200,
            'data' => $this->resource,
            'message' => 'Successfully deleted post!'
        ];
    }
}
