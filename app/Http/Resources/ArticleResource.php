<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'article_id'          => $this->article_id,
            'title'               => $this->title,
            'slug'                => $this->slug,
            'content'             => $this->content,
            'excerpt'             => $this->excerpt,
            'featured_image_url'  => $this->featured_image_url
            ? asset($this->featured_image_url)
            : null,
            'user_id'             => $this->user_id,
            'article_category_id' => $this->article_category_id,
            'type'                => $this->type,
            'status'              => $this->status,
            'published_at'        => $this->published_at ? $this->published_at->toDateTimeString() : null,
            'event_start_time'    => $this->event_start_time,
            'event_end_time'      => $this->event_end_time,
            'event_location'      => $this->event_location,
            'meta_keywords'       => $this->meta_keywords,
            'meta_description'    => $this->meta_description,
            'view_count'          => $this->view_count,
            'created_at'          => $this->created_at?->toDateTimeString(),
            'updated_at'          => $this->updated_at?->toDateTimeString(),
            'deleted_at'          => $this->deleted_at?->toDateTimeString(),

            'category'            => [
                'name' => optional($this->category)->name,
                'slug' => optional($this->category)->slug,
            ],
            'user'                => [
                'full_name' => optional($this->user)->full_name,
            ],
        ];
    }
}
