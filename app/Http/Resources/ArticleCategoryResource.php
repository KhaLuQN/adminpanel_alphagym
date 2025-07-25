<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ArticleCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->category_id,
            'name'            => $this->name,
            'slug'            => $this->slug,
            'description'     => $this->description,
            'cover_image_url' => $this->cover_image_url
            ? asset(Storage::url($this->cover_image_url))
            : null,
            'articles_count'  => $this->whenCounted('articles'),
        ];
    }
}
