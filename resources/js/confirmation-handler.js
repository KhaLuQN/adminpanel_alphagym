document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".confirm-action-btn").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            const formId = this.dataset.formId;

            if (!formId || !document.getElementById(formId)) {
                console.error(
                    `Lỗi: Không tìm thấy form với ID được cung cấp: '${formId}'`
                );

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Đã có lỗi xảy ra. Không tìm thấy form để thực thi.",
                });
                return;
            }

            const options = {
                title: this.dataset.swalTitle || "Bạn có chắc chắn?",
                text:
                    this.dataset.swalText ||
                    "Hành động này có thể không thể hoàn tác!",
                icon: this.dataset.swalIcon || "warning",
                showCancelButton: true,
                confirmButtonText: this.dataset.swalConfirmText || "Xác nhận",
                cancelButtonText: this.dataset.swalCancelText || "Hủy",
                customClass: {
                    confirmButton:
                        this.dataset.swalConfirmClass || "btn btn-success ml-2",
                    cancelButton:
                        this.dataset.swalCancelClass || "btn btn-outline",
                },
                buttonsStyling: false,
            };

            Swal.fire(options).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        });
    });
});
