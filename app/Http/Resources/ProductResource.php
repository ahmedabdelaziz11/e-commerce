<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'Description' => $this->description,
            'Price' => $this->price,
            'VAT' => $this->is_included_vat ? 'included VAT' : 'not inclided VAT',
            'Store' => new StoreResource($this->whenLoaded('store')),
            'storeOwner' => new UserResource($this->whenLoaded('storeOwner')),
        ];
    }
}
