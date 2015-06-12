/*Following lines show jslint to not throw error's for jquery*/
/*jslint browser: true*/
/*global $, jQuery, bootbox*/
"use strict";

$(document).ready(function () {
    $('#adminUserOverview').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.7/i18n/Dutch.json"
        }
    });
    $(document).on("click", "a[data-bb]", function (e) {
        var link = $(this).attr('href');
        e.preventDefault();
        bootbox.setDefaults({
            locale: "nl"
        });
        bootbox.confirm("Ben je zeker?", function (result) {
            if (result) {
                window.location = link;
            }
        });
    });
});
