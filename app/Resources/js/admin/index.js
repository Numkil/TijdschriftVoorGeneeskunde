/*Following lines show jslint to not throw error's for jquery*/
/*jslint browser: true*/
/*global $, jQuery, bootbox*/
"use strict";

$(document).ready(function () {
    $('#adminUserOverview').DataTable();
    $(document).on("click", "a[data-bb]", function (e) {
        var link = $(this).attr('href');
        e.preventDefault();
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                window.location = link;
            }
        });
    });
});
