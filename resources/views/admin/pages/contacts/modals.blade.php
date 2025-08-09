<!-- Reply Email Modal (chung) -->
<dialog id="replyEmailModal" class="modal">
    <div class="modal-box w-full max-w-2xl">
        <h3 class="font-bold text-lg mb-2">Gửi phản hồi tới khách hàng</h3>

        <form id="replyEmailForm" method="POST" action="{{ route('admin.contacts.reply') }}">
            @csrf
            <input type="hidden" name="contact_id" id="reply_contact_id" value="">
            <input type="hidden" name="to_email" id="reply_to_email" value="">

            <div class="mb-3">
                <label class="label">
                    <span class="label-text">Gửi tới</span>
                </label>
                <input type="text" id="reply_to_display" class="input input-bordered w-full" disabled>
            </div>

            <div class="mb-3">
                <label class="label">
                    <span class="label-text">Tiêu đề</span>
                </label>
                <input type="text" name="subject" id="reply_subject" class="input input-bordered w-full"
                    value="Phản hồi từ GymTech" required>
            </div>

            <div class="mb-3">
                <label class="label">
                    <span class="label-text">Nội dung</span>
                </label>
                <textarea name="message" id="reply_body" rows="8" class="textarea textarea-bordered w-full" required>
Xin chào,

Cảm ơn bạn đã gửi phản hồi tới GymTech. Chúng tôi đã nhận được phản hồi của bạn và đang xem xét. Dưới đây là phản hồi chính thức từ chúng tôi — bạn có thể chỉnh sửa hoặc bổ sung trước khi gửi:

[Viết nội dung ở đây...]

Trân trọng,
GymTech
                </textarea>
            </div>

            <div class="modal-action">
                <button type="submit" class="btn btn-primary">
                    <i class="ri-send-plane-line"></i> Gửi
                </button>
                <button type="button" class="btn" id="reply_cancel_btn">Hủy</button>
            </div>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
