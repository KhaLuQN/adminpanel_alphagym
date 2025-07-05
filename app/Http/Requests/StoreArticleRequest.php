<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize()
    {return true;}

    public function rules()
    {
        return [
            'title'               => 'required|string|max:255',
            'slug'                => 'required|string|unique:articles|max:255',
            'content'             => 'required|string',
            'excerpt'             => 'nullable|string|max:255',
            'featured_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id'             => 'required|exists:users,id',
            'article_category_id' => 'nullable|exists:article_categories,category_id',
            'type'                => 'required|in:news,event,blog,promotion',
            'status'              => 'required|in:draft,published,archived',
            'published_at'        => 'nullable|date',
            'event_start_time'    => 'nullable|date',
            'event_end_time'      => 'nullable|date',
            'event_location'      => 'nullable|string|max:255',
            'meta_keywords'       => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string|max:255',
        ];
    }
}
