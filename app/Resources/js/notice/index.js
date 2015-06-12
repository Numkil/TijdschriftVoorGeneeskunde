/*Following lines show jslint to not throw error's for jquery*/
/*jslint browser: true*/
/*global $, jQuery, bootbox*/
"use strict";

$(document).ready(function () {
    $('#adminNoticeOverview').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.7/i18n/Dutch.json"
        }
    });

    //Bootbox from admin/index.js inherited
});
