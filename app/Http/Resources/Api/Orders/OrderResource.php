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
            'from_date' => \Carbon\Carbon::parse($this->from_date)->format('Y-m-d'),
            'from_slot' => \Carbon\Carbon::parse($this->from_slot)->format('H:i'),
            'delivery_address' => AddressResource::make($this->delivery_address),
            'delivery_date' => \Carbon\Carbon::parse($this->delivery_date)->format('Y-m-d'),
            'delivery_slot' => \Carbon\Carbon::parse($this->delivery_slot)->format('H:i'),
            'return_address' => AddressResource::make($this->return_address),
            'return_date' => \Carbon\Carbon::parse($this->return_date)->format('Y-m-d'),
            'return_slot' => \Carbon\Carbon::parse($this->return_slot)->format('H:i'),
            'delivery2_address' => AddressResource::make($this->delivery2_address),
            'delivery2_date' => \Carbon\Carbon::parse($this->delivery2_date)->format('Y-m-d'),
            'delivery2_slot' => \Carbon\Carbon::parse($this->delivery2_slot)->format('H:i'),
            'return2_address' => AddressResource::make($this->return2_address),
            'return2_date' => \Carbon\Carbon::parse($this->return2_date)->format('Y-m-d'),
            'return2_slot' => \Carbon\Carbon::parse($this->return2_slot)->format('H:i'),
            'container' => ContainerResource::make($this->container),
            'weight' => $this->weight,
            'price' => $this->price,
            'status' => $this->order_status,
            'created_date' => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d')
        ];
    }
}
