<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'orders',
            'id' => (string)$this->id,
            'attributes' => [
                'email' => $this->email,
                'phone' => (int)$this->phone,
            ],
            'links' => [
                'self' => route('orders.show', ['order' => $this->id]),
            ]
        ];
    }
}
