import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

import $ from "jquery";
window.$ = $;
window.jQuery = $;

import DataTable from "datatables.net-dt";
import "./datatable-init.js";

import Swal from "sweetalert2";
window.Swal = Swal;
