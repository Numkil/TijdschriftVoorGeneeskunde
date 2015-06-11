/*Following lines show jslint to not throw error's for jquery*/
/*jslint browser: true*/
/*global $, jQuery, bootbox*/
"use strict";

$(document).ready(function () {
    $('#adminPromoOverview').DataTable();
    $(document).on("click", "a[data-bb]", function (e) {
        e.preventDefault();
        bootbox.prompt("New promo code", function (result) {
            $.post("admin/promo/new/{id}", result);
        });
    });
});
