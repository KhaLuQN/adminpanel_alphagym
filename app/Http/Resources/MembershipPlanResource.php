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
            'price'            => $this->price,
            'duration_days'    => $this->duration_days,
            'discount_percent' => $this->discount_percent,
            'description'      => $this->description,

            'features'         => $this->whenLoaded('features', function () {
                return $this->features->map(function ($feature) {
                    return [
                        'name'  => $feature->name,
                        'icon'  => $feature->icon,
                        'value' => $feature->pivot->feature_value,
                    ];
                });
            }),
        ];
    }
}
