<?php

namespace App\Http\Resources\Api\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Addresses\AddressResource;
use App\Http\Resources\Api\Containers\ContainerResource;

class OrderResource extends JsonResource
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
            'from_address' => AddressResource::make($this->from_address),
            'delivery_address' => AddressResource::make($this->delivery_address),
            'container' => ContainerResource::make($this->container),
            'weight' => $this->weight,
            'price' => $this->price,
        ];
    }
}
