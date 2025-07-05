document.addEventListener("DOMContentLoaded", function () {
    $(".datatable").each(function () {
        // Hủy bảng cũ nếu đã khởi tạo
        if ($.fn.DataTable.isDataTable(this)) {
            $(this).DataTable().destroy();
        }

        $(this).DataTable({
            responsive: true,
            autoWidth: false,
            columnDefs: [{ targets: "_all", defaultContent: "-" }],
            language: {
                sProcessing: "Đang xử lý...",
                sLengthMenu: "Hiển thị _MENU_ mục",
                sZeroRecords: "Không tìm thấy dòng nào phù hợp",
                sInfo: "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                sInfoEmpty: "Đang xem 0 đến 0 trong tổng số 0 mục",
                sInfoFiltered: "(được lọc từ _MAX_ mục)",
                sSearch: "",
                searchPlaceholder: "Tìm kiếm trong bảng...",
                paginate: {
                    previous: '<i class="ri-arrow-left-s-line"></i> ',
                    next: ' <i class="ri-arrow-right-s-line"></i>',
                },
            },
            lengthMenu: [
                [5, 10, 15, 20],
                [5, 10, 15, 20],
            ],
            dom:
                '<"flex flex-col md:flex-row justify-between items-center gap-4 mb-4" <"flex items-center gap-2"l> f >' +
                "t" +
                '<"flex flex-col md:flex-row justify-between items-center gap-4 mt-4" i p >',
        });
    });
});
