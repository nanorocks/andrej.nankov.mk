<?php

namespace App\Http\Resources\Profile;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray($request)
    {
        if (is_null($this->resource)) {
            return [
                'code' => 404,
                'data' => null,
                'message' => "No resources for index action!"
            ];
        }

        return is_array($this->resource) ? $this->resource : [
            'code' => 200,
            'data' => $this->serializeJson(parent::toArray($request)),
            'message' => 'Resources found!'
        ];
    }

    private function serializeJson(array $data)
    {
        $data[User::SOC_MEDIA] = json_decode($data[User::SOC_MEDIA]);
        $data[User::QUOTES] = json_decode($data[User::QUOTES]);

        return $data;
    }
}
