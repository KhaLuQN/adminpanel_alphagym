import "datatables.net-dt/css/dataTables.dataTables.min.css";
import "datatables.net-buttons-dt/css/buttons.dataTables.min.css";
import "datatables.net-buttons/js/buttons.html5";
import jszip from "jszip";
window.JSZip = jszip;
$(".datatable").each(function () {
    let tableOrder = $(this).data("order") || [[0, "asc"]];
    if ($.fn.DataTable.isDataTable(this)) {
        $(this).DataTable().destroy();
    }
    $(this).DataTable({
        responsive: true,
        autoWidth: false,
        order: tableOrder,
        columnDefs: [
            { targets: "_all", defaultContent: "-" },
            { targets: 0, orderable: false },
        ],
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
            '<"flex flex-col md:flex-row justify-between items-center gap-4 mb-4" <"flex items-center gap-2"B l> f >' +
            "t" +
            '<"flex flex-col md:flex-row justify-between items-center gap-4 mt-4" i p >',
        buttons: [
            {
                extend: "excelHtml5",
                text: '<i class="ri-file-excel-2-line "></i> Excel',
                className: "bg-green-700 btn   ",
                titleAttr: "Xuất ra file Excel",
            },
            {
                extend: "pdfHtml5",
                text: '<i class="ri-file-pdf-2-line mr-1"></i> PDF',
                className: "btn btn-sm",
                titleAttr: "Xuất ra file PDF",
            },
        ],
    });
});
