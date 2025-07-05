<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;

class MembershipplanController extends Controller
{
    public function index()
    {
        $packages = MembershipPlan::orderBy('price', 'asc')->paginate(10);

        return view(
            'admin.pages.package.index', compact('packages'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'plan_id'          => 'required|integer|exists:membership_plans,plan_id',

            'plan_name'        => 'required|string|max:255',
            'duration_days'    => 'required|integer|min:1',
            'price'            => 'required|numeric|min:0',
            'discount_percent' => 'required|numeric|min:0|max:100',
        ]);

        try {
            $package = MembershipPlan::findOrFail($request->plan_id);

            $package->update([
                'plan_name'        => $request->plan_name,
                'duration_days'    => $request->duration_days,
                'price'            => $request->price,
                'discount_percent' => $request->discount_percent,
            ]);

            return redirect()->back()->with('success', 'Cập nhật gói tập thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.pages.package.create');

    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_name'        => 'required|string|max:255',
            'duration_days'    => 'required|integer|min:1',
            'price'            => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        try {
            MembershipPlan::create([
                'plan_name'        => $request->plan_name,
                'duration_days'    => $request->duration_days,
                'price'            => $request->price,
                'discount_percent' => $request->discount_percent ?? 0,
            ]);

            return redirect()->route('admin.package.index')->with('success', 'Thêm gói tập thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $plan = MembershipPlan::findOrFail($id);
            $plan->delete();

            return redirect()->back()->with('success', 'Xoá gói tập thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xoá: ' . $e->getMessage());
        }
    }

}
