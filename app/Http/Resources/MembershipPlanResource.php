<?php

// app/Http/Resources/MembershipPlanResource.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->plan_id,
            'name'             => $this->plan_name,
            'durationDays'     => $this->duration_days,
            'price'            => $this->price,
            'description'      => $this->description,
            'discount_percent' => $this->discount_percent,

        ];
    }
}
