<div x-data="editTrainerModal()" x-cloak :class="{ 'modal-open': open }" class="modal">
    <div class="modal-box w-full max-w-2xl">
        <div class="flex justify-between items-center border-b pb-4">
            <h3 class="text-xl font-bold">Sửa huấn luyện viên</h3>
            <button type="button" class="btn btn-sm btn-ghost" @click="open = false">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>

        <form :action="trainer.update_url" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" :value="trainer.id">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label-text">Họ tên</label>
                    <input type="text" name="name" x-model="trainer.name" class="input input-bordered w-full"
                        disabled>
                </div>
                <div>
                    <label class="label-text">Chuyên môn</label>
                    <input type="text" name="specialty" x-model="trainer.specialty"
                        class="input input-bordered w-full">
                </div>
                <div>
                    <label class="label-text">Kinh nghiệm (năm)</label>
                    <input type="number" name="experience_years" x-model="trainer.experience_years"
                        class="input input-bordered w-full">
                </div>
                <div>
                    <label class="label-text">Chứng chỉ</label>
                    <input type="text" name="certifications" x-model="trainer.certifications"
                        class="input input-bordered w-full">
                </div>
                <div class="col-span-2">
                    <label class="label-text">Tiểu sử</label>
                    <textarea name="bio" x-model="trainer.bio" class="textarea textarea-bordered w-full"></textarea>
                </div>
                <div>
                    <label class="label-text">Facebook URL</label>
                    <input type="url" name="facebook_url" x-model="trainer.facebook_url"
                        class="input input-bordered w-full">
                </div>
                <div>
                    <label class="label-text">Instagram URL</label>
                    <input type="url" name="instagram_url" x-model="trainer.instagram_url"
                        class="input input-bordered w-full">
                </div>
                <div class="col-span-2">
                    <label class="label-text">Ảnh hiện tại</label>
                    <img :src="trainer.photo_url" alt="Trainer Photo" class="h-32 rounded mt-2">
                </div>
                <div class="col-span-2">
                    <label class="label-text">Đổi ảnh mới</label>
                    <input type="file" name="photo" class="file-input w-full">
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
    function editTrainerModal() {
        return {
            open: false,
            trainer: {},
            init() {
                document.addEventListener('open-edit-trainer-modal', (event) => {
                    this.trainer = {
                        id: event.detail.id,
                        name: event.detail.name,
                        specialty: event.detail.specialty,
                        experience_years: event.detail.experience,
                        bio: event.detail.bio,
                        certifications: event.detail.certifications,
                        facebook_url: event.detail.facebook,
                        instagram_url: event.detail.instagram,
                        photo_url: event.detail.photo,
                        update_url: event.detail.updateUrl,
                    };
                    this.open = true;
                });
            }
        };
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('editTrainerModal', editTrainerModal);
    });

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.edit-trainer-btn').forEach(button => {
            button.addEventListener('click', () => {
                const data = {
                    id: button.dataset.id,
                    name: button.dataset.name,
                    specialty: button.dataset.specialty,
                    experience: button.dataset.experience,
                    bio: button.dataset.bio,
                    certifications: button.dataset.certifications,
                    facebook: button.dataset.facebook,
                    instagram: button.dataset.instagram,
                    photo: button.dataset.photo,
                    updateUrl: button.dataset.updateUrl
                };
                document.dispatchEvent(new CustomEvent('open-edit-trainer-modal', {
                    detail: data
                }));
            });
        });
    });
</script>
