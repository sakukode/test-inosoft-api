<?php

namespace App\Http\Resources\Vehicles;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderReportResource extends JsonResource
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
            'date' => Carbon::instance($this->date->toDateTime()),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => ($this->quantity * $this->price),
            'customer' => $this->customer
        ];
    }
}
