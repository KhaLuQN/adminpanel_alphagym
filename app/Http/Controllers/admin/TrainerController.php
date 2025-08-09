<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TrainerProfile;
use App\Services\TrainerService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TrainerController extends Controller
{
    protected $trainerService;

    public function __construct(TrainerService $trainerService)
    {
        $this->trainerService = $trainerService;
    }

    public function index()
    {
        $trainers = $this->trainerService->getTrainersForIndex();
        return view('admin.pages.trainers.index', compact('trainers'));
    }

    public function create()
    {
        $members = $this->trainerService->getMembersForCreate();
        return view('admin.pages.trainers.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id'        => 'required|exists:members,member_id|unique:trainer_profiles,member_id',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'specialty'        => ['required', Rule::in(['Tăng cơ', 'Giảm cân', 'Yoga', 'Vật lý trị liệu', 'Dinh dưỡng thể hình', 'Calisthenics', 'Chạy bộ & Sức bền'])],
            'bio'              => 'nullable|string',
            'certifications'   => 'nullable|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'price_per_session'=> 'nullable|integer|min:0',
            'is_active'        => 'required|boolean',
            'facebook_url'     => 'nullable|url',
            'instagram_url'    => 'nullable|url',
        ]);

        $this->trainerService->createTrainer($validated);

        return redirect()->route('admin.trainers.index')->with('success', 'Thêm huấn luyện viên thành công!');
    }

    public function edit(TrainerProfile $trainer)
    {
        return view('admin.pages.trainers.edit', compact('trainer'));
    }

    public function update(Request $request, TrainerProfile $trainer)
    {
        $validated = $request->validate([
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'specialty'        => ['required', Rule::in(['Tăng cơ', 'Giảm cân', 'Yoga', 'Vật lý trị liệu', 'Dinh dưỡng thể hình', 'Calisthenics', 'Chạy bộ & Sức bền'])],
            'bio'              => 'nullable|string',
            'certifications'   => 'nullable|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'price_per_session'=> 'nullable|integer|min:0',
            'is_active'        => 'required|boolean',
            'facebook_url'     => 'nullable|url',
            'instagram_url'    => 'nullable|url',
        ]);

        $this->trainerService->updateTrainer($trainer, $validated);

        return redirect()->route('admin.trainers.index')->with('success', 'Cập nhật thông tin HLV thành công!');
    }

    public function destroy(TrainerProfile $trainer)
    {
        $this->trainerService->deleteTrainer($trainer);
        return redirect()->route('admin.trainers.index')->with('success', 'Đã xóa HLV thành công!');
    }
}
