<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->article_id,
            'title'         => $this->title,
            'slug'          => $this->slug,
            'content'       => $this->when($request->route()->getName() === 'articles.show', $this->content),
            'excerpt'       => $this->excerpt,
            'image'         => $this->featured_image_url
            ? asset(Storage::url($this->featured_image_url))
            : null,
            'publishedDate' => $this->published_at ? $this->published_at->toIso8601String() : null,
            'category_name' => $this->category->name ?? null,
        ];
    }
}
