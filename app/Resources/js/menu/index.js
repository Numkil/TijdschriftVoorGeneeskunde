/*Following lines show jslint to not throw error's for jquery*/
/*jslint browser: true*/
/*global $, jQuery, bootbox*/
"use strict";

$(document).ready(function () {
    $(".side-nav li a").each(function (element) {
        element.append("<span class='glyphicon glyphicon-menu-right'></span>");
        console.log(element);
    });
    console.log($(".side-nav li"));
});