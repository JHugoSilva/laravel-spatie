<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
            'id' => $this->id,
            'transaction' => $this->transaction_code,
            'food' => new FoodResource($this->food),
            'price' => $this->price,
            'quantity' => $this->quantity,
            'sum' => $this->sum,
            'status' => $this->status,
            'user' => $this->user->name
        ];
    }
}
