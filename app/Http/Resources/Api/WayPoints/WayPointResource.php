<?php

namespace App\Http\Resources\Api\WayPoints;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Addresses\AddressResource;
use App\Http\Resources\UserResource;

class WayPointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'address' => AddressResource::make($this->address),
          'user' => UserResource::make($this->user),
          'type' => $this->getType(),
          'location'=> $this->location
        ];
    }
}
