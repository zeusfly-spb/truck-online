<?php

namespace App\Http\Resources\Api\Cars;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassResource extends JsonResource
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
          'name'  => $this->getTranslation('name', 'app()->getLocale()'),
          'number'=> $this->number,
          'date'  => $this->date
      ];
    }
}
