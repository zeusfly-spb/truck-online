<?php

namespace App\Http\Resources\Api\Cars;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Companies\CompanyResource;
use App\Http\Resources\Api\Cars\CarTypeResource;
use App\Http\Resources\Api\Cars\CarPassResource;
use App\Http\Resources\Api\Countries\CountryResource;

class CarResource extends JsonResource
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
        'icon'    => $this->icon,
        'number'    => $this->number,
        'mark_model' => $this->mark_model,
        'sts' => $this->sts,
        'max_weigth' => $this->max_weigth,
        //'company'   => CompanyResource::make($this->company),
        'country'  => CountryResource::make($this->country),
        'car_type' => CarTypeResource::make($this->car_type),
        'sts_file_1'    => $this->sts_file_1,
        'sts_file_2'    => $this->sts_file_2,
        'passes'=> CarPassResource::collection($this->passes)
      ];
    }
}
