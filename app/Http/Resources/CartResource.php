<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'sub_total' => $this->sub_total,
            'shipping_cost' => $this->shipping_cost,
            'vat_value' => $this->vat_value,
            'cartOwner' => new UserResource($this->whenLoaded('user')),
            'products' => CartProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
