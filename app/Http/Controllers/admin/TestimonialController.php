<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::latest('submitted_at')->paginate(15);
        return view('admin.pages.testimonials.index', compact('testimonials'));
    }

    /**
     * Approve or unapprove the specified testimonial.
     */
    public function approve(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_approved' => ! $testimonial->is_approved,
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Cập nhật trạng thái đánh giá thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Xóa đánh giá thành công.');
    }
}
