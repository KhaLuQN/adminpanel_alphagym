<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Models\Equipment;
use App\Services\EquipmentService;

class EquipmentController extends Controller
{
    protected $service;

    public function __construct(EquipmentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $equipments = $this->service->getEquipmentsForIndex();
        return view('admin.pages.equipment.index', compact('equipments'));
    }

    public function create()
    {
        return view('admin.pages.equipment.create');
    }

    public function store(StoreEquipmentRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Thêm thiết bị mới thành công!');
    }

    public function update(UpdateEquipmentRequest $request)
    {
        $equipment = Equipment::findOrFail($request->id);
        $this->service->update($request->validated(), $equipment);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Cập nhật thông tin thiết bị thành công!');
    }

    public function destroy(Equipment $equipment)
    {
        $this->service->delete($equipment);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Xóa thiết bị thành công!');
    }
}
