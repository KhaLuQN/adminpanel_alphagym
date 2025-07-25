<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEquipmentRequest;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::orderBy('status')->orderBy('purchase_date', 'desc')->get();
        return view('admin.pages.equipment.index', compact('equipments'));
    }

    public function create()
    {

        return view('admin.pages.equipment.create');
    }

    public function store(StoreEquipmentRequest $request)
    {
        $validated = $request->validate();

        if ($request->hasFile('img')) {
            $file     = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin/images/equipment'), $filename);
            $validated['img'] = 'admin/images/equipment/' . $filename;
        }

        Equipment::create($validated);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Thêm thiết bị mới thành công!');
    }

    public function update(Request $request, Equipment $equipment)
    {

        $request->validate([
            'id'            => 'required|exists:equipment,id',
            'name'          => 'required|string|max:255',
            'img'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'purchase_date' => 'required|date',
            'status'        => 'required|in:working,maintenance,broken',
            'location'      => 'nullable|string|max:255',
            'notes'         => 'nullable|string',
        ]);

        $equipment = Equipment::findOrFail($request->id);

        $equipment->name          = $request->name;
        $equipment->purchase_date = $request->purchase_date;
        $equipment->status        = $request->status;
        $equipment->location      = $request->location;
        $equipment->notes         = $request->notes;
        if ($request->hasFile('img')) {
            $file     = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin/images/equipment'), $filename);
            $equipment->img = 'admin/images/equipment/' . $filename;
        }

        $equipment->save();

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Cập nhật thông tin thiết bị thành công!');
    }

    public function destroy(Equipment $equipment)
    {

        if ($equipment->img) {
            Storage::disk('public')->delete($equipment->img);
        }

        $equipment->delete();

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Xóa thiết bị thành công!');
    }
}
