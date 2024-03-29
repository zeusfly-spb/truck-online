<?php

namespace App\Http\Resources\Api\Containers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContainerResource extends JsonResource
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
            'name' => $this->getTranslation('name', app()->getLocale()),
            'weight' => $this->weight,
            'kit' => $this->kit
        ];
    }
}
