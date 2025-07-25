import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

import $ from "jquery";
window.$ = $;
window.jQuery = $;

import Swal from "sweetalert2";
window.Swal = Swal;
if (document.querySelector(".datatable")) {
    import("./datatable-init.js").then((module) => {
        console.log("DataTable loaded");
    });
}
import "remixicon/fonts/remixicon.css";
if (document.querySelector("[data-confirm-delete]")) {
    import("./delete-confirmation.js").then(() => {
        console.log("delete-confirmation.js loaded");
    });
}
