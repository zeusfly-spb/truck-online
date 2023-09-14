<?php

namespace App\Http\Resources\Api\Addresses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id'    => $this->id,
          'name' => $this->name,
          'address' => $this->address,
          'coordinates' => $this->location,
          'return' => $this->return,
          'from' => $this->from,
          'to' => $this->to,
      ];
    }
}
