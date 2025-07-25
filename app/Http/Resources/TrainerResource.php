<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TrainerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,

            'full_name'         => $this->member->full_name,

            'photo_url'         => $this->photo_url
            ? asset(Storage::url($this->photo_url))
            : null,
            'specialty'         => $this->specialty,
            'bio'               => $this->bio,
            'experience_years'  => $this->experience_years,
            'certifications'    => $this->certifications,
            'facebook_url'      => $this->facebook_url,
            'instagram_url'     => $this->instagram_url,
            'slug'              => $this->slug,
            'price_per_session' => $this->price_per_session,
            'average_rating'    => $this->average_rating,
            'badge_class'       => $this->badge_class,
        ];
    }
}
