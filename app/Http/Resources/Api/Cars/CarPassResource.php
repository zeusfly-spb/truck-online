<?php

namespace App\Http\Resources\Api\Cars;

use App\Http\Resources\Api\Cars\PassResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarPassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'pass' => PassResource::make($this->pass)
        ];
    }
}
