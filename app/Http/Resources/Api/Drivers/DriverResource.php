<?php

namespace App\Http\Resources\Api\Drivers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Document;
use App\Models\File;
use App\Http\Resources\Api\Documents\DocumentResource;
class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id'  =>  $this->id,
          'first_name' => $this->first_name,
          'middle_name' => $this->middle_name,
          'last_name' => $this->last_name,
          'email' => $this->email,
          'phone' => $this->phone,
          'document'=> DocumentResource::make(
            Document::where('table_owner', 'User')->where('table_owner_id', $this->id)->where('name', 'Водителькое удостоверение')->first()),
          'files' => File::where('table_owner', 'User')->where('table_owner_id', $this->id)->pluck('path'),
        ];
    }
}
