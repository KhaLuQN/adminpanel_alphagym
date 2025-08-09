<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTestimonialRequest;
use App\Http\Resources\TestimonialResource;
use App\Models\Member;
use App\Models\Testimonial;

class TestimonialController extends Controller
{

    public function index()
    {
        $testimonials = Testimonial::where('is_approved', 1)

            ->latest('submitted_at')
            ->limit(8)
            ->get();

        return TestimonialResource::collection($testimonials);
    }

    public function store(StoreTestimonialRequest $request)
    {
        $validated = $request->validated();

        $member = Member::where('phone', $validated['phone'])->first();
        if (! $member) {
            return response()->json(['message' => 'Số điện thoại không tồn tại trong hệ thống. Chỉ hội viên mới có thể gửi đánh giá.'], 404);
        }

        if ($member) {
            $existingTestimonial = Testimonial::where('member_id', $member->member_id)->first();

            if ($existingTestimonial) {
                return response()->json(['message' => 'Bạn đã gửi đánh giá trước đó.'], 409);
            }
        }
        $submittedAt = now();
        $imagePath   = $request->hasFile('image')
        ? $request->file('image')->store('testimonials', 'public')
        : null;

        $testimonial = Testimonial::create([
            'customer_name'       => $validated['customer_name'],
            'testimonial_content' => $validated['content'],
            'rating'              => $validated['rating'],
            'image_url'           => $request->hasFile('image')
            ? $request->file('image')->store('testimonials', 'public')
            : null,
            'submitted_at'        => $submittedAt,
            'member_id'           => $member ? $member->member_id : null,
            'is_approved'         => 0,
        ]);

        return response()->json([
            'message' => 'Cảm ơn bạn đã gửi phản hồi! Phản hồi của bạn sẽ được xem xét.',
            'data'    => new TestimonialResource($testimonial),
        ], 201);
    }
}
