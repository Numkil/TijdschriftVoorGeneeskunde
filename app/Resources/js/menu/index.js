/*Following lines show jslint to not throw error's for jquery*/
/*jslint browser: true*/
/*global $, jQuery, bootbox*/
"use strict";

$(document).ready(function () {
    $(".side-nav li a").each(function () {
        //element.append("<span class='glyphicon glyphicon-menu-right'></span>");
        $(this).append("<span class='glyphicon glyphicon-menu-right' style='float:right;margin-left:15px;visibility:hidden;'></span>");
    });
    $(".side-nav li a").hover(function () {
        $(".side-nav li span").css({visibility: "visible"});
    }, function () {
        $(".side-nav li span").css({visibility: "hidden"});
    });

});