<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->testimonial_id,
            'customer_name' => $this->customer_name,
            'content'       => $this->testimonial_content,
            'rating'        => $this->rating,
            'image_url'     => $this->image_url ? asset($this->image_url) : null,
            'submitted_at'  => $this->submitted_at->format('d/m/Y'),
        ];
    }
}
