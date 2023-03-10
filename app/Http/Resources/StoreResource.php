<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'ID' => $this->id,
            'Name' => $this->name,
            'VAT' => $this->VAT,
            'ShippingCost' => $this->shipping_cost,
            'owner' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
