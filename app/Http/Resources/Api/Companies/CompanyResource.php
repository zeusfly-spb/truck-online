<?php

namespace App\Http\Resources\Api\Companies;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\Api\Taxes\TaxResource;
use App\Http\Resources\Api\Countries\CountryResource;
use App\Http\Resources\Api\Addresses\AddressResource;

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
          'iin'=> $this->iin,
          'kpp'=> $this->kpp,
          'ogrn'=> $this->ogrn,
          'phone'=> $this->phone,
          'email'=> $this->email,
          'short_name'=> $this->short_name,
          'full_name'=> $this->full_name,
          'link'=> $this->link,
          'company_reg_date'=> $this->company_reg_date,
          'edo_provider'=> $this->edo_provider,
          'edo_id'=> $this->edo_id,
          'user' => UserResource::make($this->user),
          'tax' => TaxResource::make($this->tax),
          'country' => CountryResource::make($this->country),
          'address' => AddressResource::make($this->address),
          'post_address' => AddressResource::make($this->post_address),
          'contact'=> $this->contact,
          'data_contract' => $this->data_contract,
          'ceo_name' => $this->ceo_name,
          'cceo_name' => $this->cceo_name,
          'cceo_contract_name' => $this->cceo_contract_name,
          'cceo_contract_date' => $this->cceo_contract_date
        ];
    }
}
