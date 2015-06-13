/*Following lines show jslint to not throw error's for jquery*/
/*jslint browser: true*/
/*global $, jQuery, bootbox*/
/***
"use strict";

$(document).ready(function () {
    $('#adminPromoOverview').DataTable({
        "language": {

            "url": "https://cdn.datatables.net/plug-ins/1.10.7/i18n/Dutch.json"
        }
    });
    $(document).on("click", "a[data-bbpromo]", function (e) {
        e.preventDefault();
        bootbox.prompt("Nieuwe promo code", function (result) {
            $.post("admin/promo/new/{id}", result);
        });
    });

    //Bootbox from admin/index.js inherited for deletion confirm
});

*/
