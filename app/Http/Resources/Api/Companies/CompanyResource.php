<?php

namespace App\Http\Resources\Api\Companies;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          "id" => $this->id,
          "short_name" => $this->short_name,
        ];
    }
}
