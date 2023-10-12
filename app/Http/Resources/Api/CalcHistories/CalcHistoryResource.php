<?php

namespace App\Http\Resources\Api\CalcHistories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Containers\ContainerResource;
use App\Http\Resources\Api\Addresses\AddressResource;
use App\Http\Resources\Api\Taxes\TaxResource;

class CalcHistoryResource extends JsonResource
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
        'container' => ContainerResource::make($this->container),
        'from_address' => AddressResource::make($this->from_address),
        'delivery_address' => AddressResource::make($this->delivery_address),
        'return_address' => AddressResource::make($this->return_address),
        'delivery2_address' => AddressResource::make($this->delivery2_address),
        'return2_address' => AddressResource::make($this->return2_address),
        "tax" => TaxResource::make($this->tax),
        "price" => $this->price,
        "weight"=> $this->weight,
        "imo"=> $this->imo,
        "temp_reg"=> $this->temp_reg,
        "is_international"=> $this->is_international,
      ];
      //return parent::toArray($request);
    }
}
