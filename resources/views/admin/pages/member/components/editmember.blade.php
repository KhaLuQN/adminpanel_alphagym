 <!-- Edit Member Modal -->
 <div x-data="editMemberModal()" :class="{ 'modal-open': open }" @keydown.escape.window="open = false" class="modal">
     <div class="modal-box w-11/12 max-w-4xl">
         <div class="flex items-start justify-between pb-4 border-b border-base-300">
             <h5 class="text-2xl font-bold text-base-content" id="editMemberModalTitle">CẬP NHẬT THÔNG TIN THÀNH VIÊN</h5>
             <button type="button" @click="open = false" class="btn btn-sm btn-ghost">
                 <i class="ri-close-line text-xl"></i>
             </button>
         </div>
         <div class="mt-6">
             <form id="editMemberForm" method="POST" action="{{ route('admin.members.update') }}"
                 enctype="multipart/form-data">
                 @csrf
                 <input type="hidden" name="member_id" x-model="member.id">
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <!-- Left Column -->
                     <div class="space-y-4">
                         <div>
                             <label for="editMemberName" class="label">
                                 <span class="label-text">Họ tên <span class="text-error">*</span></span>
                             </label>
                             <input type="text" name="full_name" id="editMemberName" x-model="member.name" required
                                 class="input input-bordered w-full">
                         </div>
                         <div>
                             <label for="editMemberPhone" class="label">
                                 <span class="label-text">Số điện thoại <span class="text-error">*</span></span>
                             </label>
                             <input type="tel" name="phone" id="editMemberPhone" x-model="member.phone" required
                                 class="input input-bordered w-full">
                         </div>
                         <div>
                             <label for="editMemberEmail" class="label">
                                 <span class="label-text">Email</span>
                             </label>
                             <input type="email" name="email" id="editMemberEmail" x-model="member.email"
                                 class="input input-bordered w-full">
                         </div>
                         <div>
                             <label for="editMemberNotes" class="label">
                                 <span class="label-text">Ghi chú</span>
                             </label>
                             <textarea name="notes" id="editMemberNotes" x-model="member.notes" rows="3"
                                 class="textarea textarea-bordered w-full"></textarea>
                         </div>
                         <div>
                             <label for="editMemberStatus" class="label">
                                 <span class="label-text">Trạng thái <span class="text-error">*</span></span>
                             </label>
                             <select id="editMemberStatus" name="status" x-model="member.status"
                                 class="select select-bordered w-full">
                                 <option value="active">Hoạt động</option>
                                 <option value="expired">Hết hạn</option>
                                 <option value="banned">Bị khóa</option>
                             </select>
                         </div>
                     </div>
                     <!-- Right Column -->
                     <div class="space-y-4">
                         <div>
                             <label class="label">
                                 <span class="label-text">Ảnh đại diện</span>
                             </label>
                             <div class="mt-2 flex items-center space-x-4">
                                 <div class="avatar">
                                     <div class="w-24 h-24 rounded-full">
                                         <img :src="member.image" alt="Current Avatar" class="object-cover" />
                                     </div>
                                 </div>
                                 <input type="file" name="img" id="editMemberAvatar"
                                     class="file-input file-input-bordered w-full" />
                             </div>
                         </div>
                         <div class="card bg-base-100 shadow-md">
                             <div class="card-body">
                                 <h6 class="card-title">QUẢN LÝ THẺ RFID</h6>
                                 <div class="form-control">
                                     <label class="label">
                                         <span class="label-text">Thẻ hiện tại</span>
                                     </label>
                                     <input type="text" :value="member.rfid" disabled
                                         class="input input-bordered w-full input-disabled">
                                 </div>
                                 <div class="form-control mt-4">
                                     <label class="label">
                                         <span class="label-text">Thêm thẻ mới</span>
                                     </label>
                                     <div class="join">
                                         <input type="text" name="rfid_card_id" id="newRfid"
                                             placeholder="Quẹt thẻ RFID vào đây" readonly
                                             class="input input-bordered join-item w-full">
                                         <button type="button" id="scanRfidBtn" class="btn btn-primary join-item">Quét
                                             thẻ</button>
                                     </div>
                                 </div>
                             </div>
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

 <script>
     function editMemberModal() {
         return {
             open: false,
             member: {},
             init() {
                 document.addEventListener('open-edit-modal', (event) => {
                     this.member = event.detail;
                     this.open = true;
                 });
             }
         }
     }

     document.addEventListener('alpine:init', () => {
         Alpine.data('editMemberModal', editMemberModal);
     });

     document.addEventListener('DOMContentLoaded', function() {
         document.querySelectorAll('.edit-member-btn').forEach(button => {
             button.addEventListener('click', function() {
                 const data = {
                     id: this.dataset.id,
                     name: this.dataset.name,
                     phone: this.dataset.phone,
                     email: this.dataset.email,
                     image: this.dataset.image,
                     notes: this.dataset.notes,
                     rfid: this.dataset.rfid,
                     status: this.dataset.status
                 };
                 document.dispatchEvent(new CustomEvent('open-edit-modal', {
                     detail: data
                 }));
             });
         });
     });
 </script>
