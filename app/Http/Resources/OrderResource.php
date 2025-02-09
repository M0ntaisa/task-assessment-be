<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\OrderItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_order' => $this->id_order,
            'id_customer' => $this->id_customer,
            'date' => $this->date,
            'status' => $this->status,
            'order_item' => OrderItemResource::collection($this->orderItem),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
