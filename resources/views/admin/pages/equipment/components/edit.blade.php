<div x-data="editEquipmentModal()" :class="{ 'modal-open': open }" @keydown.escape.window="open = false" class="modal">
    <div class="modal-box w-11/12 max-w-4xl">
        <div class="flex items-start justify-between pb-4 border-b border-base-300">
            <h5 class="text-2xl font-bold text-base-content" id="editEquipmentModalTitle">Chỉnh sửa thiết bị</h5>
            <button type="button" @click="open = false" class="btn btn-sm btn-ghost">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>
        <div class="mt-6">
            <form id="editEquipmentForm" method="POST" action="{{ route('admin.equipment.update') }}"
                enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" id="edit-id">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Left Column -->
                    <div class="md:col-span-1 space-y-4">
                        <label class="label">
                            <span class="label-text">Hình ảnh thiết bị</span>
                        </label>
                        <img id="current-img" src="" alt="Ảnh thiết bị"
                            class="w-full h-auto object-cover rounded-md shadow-md">
                        <input type="file" name="img" id="edit-img"
                            class="file-input file-input-bordered w-full" />
                    </div>
                    <!-- Right Column -->
                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <label for="edit-name" class="label">
                                <span class="label-text">Tên thiết bị <span class="text-error">*</span></span>
                            </label>
                            <input type="text" name="name" id="edit-name" required
                                class="input input-bordered w-full">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="edit-purchase_date" class="label">
                                    <span class="label-text">Ngày mua <span class="text-error">*</span></span>
                                </label>
                                <input type="date" name="purchase_date" id="edit-purchase_date" required
                                    class="input input-bordered w-full">
                            </div>
                            <div>
                                <label for="edit-status" class="label">
                                    <span class="label-text">Trạng thái <span class="text-error">*</span></span>
                                </label>
                                <select id="edit-status" name="status" required class="select select-bordered w-full">
                                    <option value="working">Đang hoạt động</option>
                                    <option value="maintenance">Bảo trì</option>
                                    <option value="broken">Hư hỏng</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="edit-location" class="label">
                                <span class="label-text">Vị trí</span>
                            </label>
                            <input type="text" name="location" id="edit-location"
                                class="input input-bordered w-full">
                        </div>
                        <div>
                            <label for="edit-notes" class="label">
                                <span class="label-text">Ghi chú</span>
                            </label>
                            <textarea name="notes" id="edit-notes" rows="3" class="textarea textarea-bordered w-full"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-action">
                    <button type="button" @click="open = false" class="btn btn-ghost">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('customjs')
    <script>
        function editEquipmentModal() {
            return {
                open: false,
                editEquipment: {},
                init() {
                    document.addEventListener('open-edit-modal', (event) => {
                        this.editEquipment = event.detail;
                        document.getElementById('edit-id').value = this.editEquipment.id;
                        document.getElementById('edit-name').value = this.editEquipment.name;
                        document.getElementById('edit-purchase_date').value = this.editEquipment.purchase_date;
                        document.getElementById('edit-status').value = this.editEquipment.status;
                        document.getElementById('edit-location').value = this.editEquipment.location;
                        document.getElementById('edit-notes').value = this.editEquipment.notes;

                        const currentImg = document.getElementById('current-img');
                        if (this.editEquipment.img) {
                            currentImg.src = this.editEquipment.img;
                            currentImg.style.display = 'block';
                        } else {
                            currentImg.style.display = 'none';
                        }


                        this.open = true;
                    });
                }
            }
        }


        document.addEventListener('alpine:init', () => {
            Alpine.data('editEquipmentModal', editEquipmentModal);
        });


        document.querySelectorAll('.btn-open-edit-modal').forEach(button => {
            button.addEventListener('click', function() {
                const equipmentData = {
                    id: this.dataset.id,
                    name: this.dataset.name,
                    purchase_date: this.dataset.purchase_date,
                    status: this.dataset.status,
                    location: this.dataset.location,
                    notes: this.dataset.notes,
                    img: this.dataset.img
                };

                document.dispatchEvent(new CustomEvent('open-edit-modal', {
                    detail: equipmentData
                }));
            });
        });
    </script>
@endpush
