<?php
namespace App\Http\Requests\Article;

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
    /**
     * Lấy các thông báo lỗi tùy chỉnh cho các quy tắc validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required'             => 'Vui lòng nhập tiêu đề bài viết.',
            'title.string'               => 'Tiêu đề phải là một chuỗi ký tự.',
            'title.max'                  => 'Tiêu đề không được vượt quá 255 ký tự.',

            'slug.required'              => 'Đường dẫn (slug) là bắt buộc.',
            'slug.unique'                => 'Đường dẫn này đã tồn tại, vui lòng chọn một đường dẫn khác.',
            'slug.max'                   => 'Đường dẫn không được vượt quá 255 ký tự.',

            'content.required'           => 'Nội dung bài viết không được để trống.',
            'content.string'             => 'Nội dung bài viết phải là một chuỗi ký tự.',

            'excerpt.max'                => 'Đoạn tóm tắt không được vượt quá 255 ký tự.',

            'featured_image.image'       => 'File tải lên phải là một hình ảnh.',
            'featured_image.mimes'       => 'Chỉ chấp nhận các định dạng ảnh: jpg, jpeg, png, gif, svg.',
            'featured_image.max'         => 'Kích thước ảnh không được vượt quá 2MB.',

            'user_id.required'           => 'Vui lòng chọn tác giả cho bài viết.',
            'user_id.exists'             => 'Tác giả được chọn không hợp lệ.',

            'article_category_id.exists' => 'Danh mục được chọn không hợp lệ.',

            'type.required'              => 'Vui lòng chọn loại bài viết.',
            'type.in'                    => 'Loại bài viết không hợp lệ.',

            'status.required'            => 'Vui lòng chọn trạng thái cho bài viết.',
            'status.in'                  => 'Trạng thái không hợp lệ.',

            'published_at.date'          => 'Ngày xuất bản phải là một ngày hợp lệ.',
            'event_start_time.date'      => 'Thời gian bắt đầu sự kiện phải là một ngày hợp lệ.',
            'event_end_time.date'        => 'Thời gian kết thúc sự kiện phải là một ngày hợp lệ.',

            'meta_keywords.max'          => 'Từ khóa meta không được vượt quá 255 ký tự.',
            'meta_description.max'       => 'Mô tả meta không được vượt quá 255 ký tự.',
        ];
    }
}
