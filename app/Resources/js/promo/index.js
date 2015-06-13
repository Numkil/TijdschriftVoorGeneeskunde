/*Following lines show jslint to not throw error's for jquery*/
/*jslint browser: true*/
/*global $, jQuery, bootbox*/
/***
"use strict";

$(document).ready(function () {
    $('#adminPromoOverview').DataTable({
        "language": {
            url: https://cdn.datatables.net/plug-ins/1.10.7/i18n/Dutch.json"
        }
    });
    $(document).on("click", "#newPromoButton", function (e) {
        var link = $(this).attr('href');
        e.preventDefault();
        bootbox.prompt("New promo code", function (result) {
            $.ajax({
                url: "/admin/promo/new/" + result,
                type: "POST",
                data: { "code" : result },
                success: function (data) {
                    window.location = link;
                    console.log(data);
                }
            });
        });
    });
});

*/
