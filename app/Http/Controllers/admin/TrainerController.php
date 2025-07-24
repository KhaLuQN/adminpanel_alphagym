<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\TrainerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = TrainerProfile::with('member')->latest()->paginate(10);

        return view('admin.pages.trainers.index', compact('trainers'));
    }

    public function create()
    {
        $members = Member::whereDoesntHave('trainerProfile')->get();
        return view('admin.pages.trainers.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id'        => 'required|exists:members,member_id|unique:trainer_profiles,member_id',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'specialty'        => 'required|in:Tăng cơ,Giảm cân,Yoga,Vật lý trị liệu,Dinh dưỡng thể hình,Calisthenics,Chạy bộ & Sức bền',
            'bio'              => 'nullable|string',
            'certifications'   => 'nullable|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'facebook_url'     => 'nullable|url',
            'instagram_url'    => 'nullable|url',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_url'] = $request->file('photo')->store('trainers', 'public');
        }

        TrainerProfile::create($validated);

        return redirect()->route('admin.trainers.index')->with('success', 'Thêm huấn luyện viên thành công!');
    }

    public function update(Request $request, TrainerProfile $trainerProfile)
    {
        $validated = $request->validate([
            'specialty'        => 'required|in:Tăng cơ,Giảm cân,Yoga,Vật lý trị liệu,Dinh dưỡng thể hình,Calisthenics,Chạy bộ & Sức bền',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bio'              => 'nullable|string',
            'certifications'   => 'nullable|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'facebook_url'     => 'nullable|url',
            'instagram_url'    => 'nullable|url',
        ]);

        if ($request->hasFile('photo')) {
            // Xóa ảnh cũ nếu có
            if ($trainerProfile->photo_url) {
                Storage::disk('public')->delete($trainerProfile->photo_url);
            }
            $validated['photo_url'] = $request->file('photo')->store('trainers', 'public');
        }

        $trainerProfile->update($validated);

        return redirect()->route('admin.trainers.index')->with('success', 'Cập nhật thông tin HLV thành công!');
    }

    public function destroy(TrainerProfile $trainerProfile)
    {
        if ($trainerProfile->photo_url) {
            Storage::disk('public')->delete($trainerProfile->photo_url);
        }
        $trainerProfile->delete();
        return redirect()->route('admin.trainers.index')->with('success', 'Đã xóa HLV thành công!');
    }
}
