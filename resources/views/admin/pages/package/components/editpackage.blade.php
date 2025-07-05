<div x-data="editPackageModal()" :class="{ 'modal-open': open }" @keydown.escape.window="open = false" class="modal">
    <div class="modal-box w-full max-w-lg">
        <div class="flex justify-between items-center border-b pb-4">
            <h3 class="text-xl font-bold">Sửa gói tập</h3>
            <button type="button" @click="open = false" class="btn btn-sm btn-ghost">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.package.update') }}" class="mt-4">
            @csrf
            <input type="hidden" name="plan_id" :value="package.plan_id">

            <div class="space-y-4">
                <div>
                    <label class="label-text">Tên gói</label>
                    <input type="text" name="plan_name" x-model="package.plan_name"
                        class="input input-bordered w-full" required>
                </div>
                <div>
                    <label class="label-text">Thời hạn (ngày)</label>
                    <input type="number" name="duration_days" x-model="package.duration_days"
                        class="input input-bordered w-full" required>
                </div>
                <div>
                    <label class="label-text">Giá (VND)</label>
                    <input type="number" name="price" x-model="package.price" class="input input-bordered w-full"
                        required>
                </div>
                <div>
                    <label class="label-text">Giảm giá (%)</label>
                    <input type="number" name="discount_percent" x-model="package.discount_percent"
                        class="input input-bordered w-full">
                </div>
            </div>

            <div class="modal-action pt-4">
                <button type="button" class="btn btn-ghost" @click="open = false">Hủy</button>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
</div>



<script>
    function editPackageModal() {
        return {
            open: false,
            package: {},
            init() {
                document.addEventListener('open-edit-modal', (event) => {
                    this.package = {
                        plan_id: event.detail.id,
                        plan_name: event.detail.name,
                        duration_days: event.detail.duration,
                        price: event.detail.price,
                        discount_percent: event.detail.discount
                    };
                    this.open = true;
                });
            }
        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('editPackageModal', editPackageModal);
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-package-btn').forEach(button => {
            button.addEventListener('click', function() {
                const data = {
                    id: this.dataset.id,
                    name: this.dataset.name,
                    duration: this.dataset.duration,
                    price: this.dataset.price,
                    discount: this.dataset.discount
                };
                document.dispatchEvent(new CustomEvent('open-edit-modal', {
                    detail: data
                }));
            });
        });
    });
</script>
