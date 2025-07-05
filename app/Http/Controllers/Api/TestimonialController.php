<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{

    public function index()
    {
        $testimonials = Testimonial::where('is_approved', 1)
            ->where('display_on_website', 1)
            ->latest('submitted_at')
            ->limit(8)
            ->get();

        return TestimonialResource::collection($testimonials);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'       => 'required|string|max:100',
            'testimonial_content' => 'required|string|max:1000',
            'rating'              => 'nullable|integer|min:1|max:5',
        ]);

        $testimonial = Testimonial::create([
            'customer_name'       => $validated['customer_name'],
            'testimonial_content' => $validated['testimonial_content'],
            'rating'              => $validated['rating'] ?? null,
            'is_approved'         => 0,
            'display_on_website'  => 0,
            'submitted_at'        => now(),
        ]);

        return response()->json([
            'message' => 'Cảm ơn bạn đã gửi phản hồi! Phản hồi của bạn sẽ được xem xét.',
            'data'    => new TestimonialResource($testimonial),
        ], 201);
    }
}
