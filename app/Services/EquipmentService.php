<?php
namespace App\Services;

use App\Models\Equipment;
use Illuminate\Support\Facades\Storage;

class EquipmentService
{
    public function getEquipmentsForIndex()
    {
        return Equipment::orderBy('status')->orderBy('purchase_date', 'desc')->get();
    }
    public function create(array $data): Equipment
    {
        if (isset($data['img']) && $data['img']->isValid()) {
            $filename    = time() . '_' . $data['img']->getClientOriginalName();
            $data['img'] = $data['img']->storeAs('equipments', $filename, 'public');
        }

        return Equipment::create($data);
    }

    public function update(array $data, Equipment $equipment): Equipment
    {
        // Xóa ảnh cũ nếu có
        if (isset($data['img']) && $data['img']->isValid()) {
            if ($equipment->img && Storage::disk('public')->exists($equipment->img)) {
                Storage::disk('public')->delete($equipment->img);
            }

            $filename    = time() . '_' . $data['img']->getClientOriginalName();
            $data['img'] = $data['img']->storeAs('equipments', $filename, 'public');
        }

        $equipment->update($data);

        return $equipment;
    }

    public function delete(Equipment $equipment): void
    {
        if ($equipment->img && Storage::disk('public')->exists($equipment->img)) {
            Storage::disk('public')->delete($equipment->img);
        }

        $equipment->delete();
    }
}
