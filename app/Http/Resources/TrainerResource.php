<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,

            'full_name'        => $this->member->full_name,

            'photo_url'        => $this->photo_url
            ? asset($this->photo_url)
            : null,
            'specialty'        => $this->specialty,
            'bio'              => $this->bio,
            'experience_years' => $this->experience_years,
            'certifications'   => $this->certifications,
            'facebook_url'     => $this->facebook_url,
            'instagram_url'    => $this->instagram_url,
        ];
    }
}
