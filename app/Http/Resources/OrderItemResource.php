<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);

        // return [
        //     'id_order_item' => $this->id_order_item,
        //     'id_order' => $this->id_order,
        //     'id_product' => $this->id_product,
        //     'quantity' => $this->quantity,
        //     'price' => $this->price,
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at
        // ];
    }
}
