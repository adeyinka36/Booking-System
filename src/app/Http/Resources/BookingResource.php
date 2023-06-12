<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'vehicle_make' => $this->vehicle_make,
            'vehicle_model' => $this->vehicle_model,
            'booking_date' => $this->booking_date,
            'booking_time' => $this->booking_time
        ];
        if($this->user){
            $data['user'] = new UserResource($this->user);
        }
        return $data;
    }
}
