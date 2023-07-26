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
          'id'    => $this->id,
          'user_name' => $this->user?->name,
          'iin'=> $this->iin,
          'phone' => $this->phone,
          'email' => $this->email,
          'first_name' => $this->first_name,
          'last_name' => $this->last_name,
          'company_reg_date' => $this->company_reg_date
        ];
    }
}
