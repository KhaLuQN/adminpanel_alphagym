document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const formId = this.dataset.formId;

            if (!formId || !document.getElementById(formId)) {
                console.error(`Không tìm thấy form với ID: ${formId}`);
                return;
            }

            Swal.fire({
                title: "Bạn có chắc chắn?",
                text: "Hành động này sẽ không thể hoàn tác!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e3342f",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy",
                customClass: {
                    confirmButton: "btn btn-error ml-2",
                    cancelButton: "btn btn-outline",
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        });
    });
});
