<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DemandResource extends JsonResource
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
            'client_id' => $this->client_id,
            'title' => $this->title,
            'priority' => $this->priority,
            'sector'  => $this->sector,
            'responsible' => $this->responsible,
            'who_should_test' => $this->who_should_test,
            'description' => $this->description,
            'midia'  => $this->midia,
            'customer_charged' => $this->customer_charged,
            'estimated_time' => $this->estimated_time,
            'time_spent' => $this->time_spent,
            'status' => $this->status,
            'return' => $this->return,
        ];
    }
}
