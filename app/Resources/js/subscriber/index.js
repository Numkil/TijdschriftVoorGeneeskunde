/*Following lines show jslint to not throw error's for jquery*/
/*jslint browser: true*/
/*global $, jQuery, bootbox*/
"use strict";

$(document).ready(function () {

    $('#sameAddress').click(function () {
        if (document.getElementById('SubscriberForm_sameaddress').checked === true) {
            document.getElementById('facturationAddress').style.display = 'none';
        } else {
            document.getElementById('facturationAddress').style.display = 'block';
        }
    });

    $(document.getElementById('SubscriberForm_save')).click(function () {
        if (document.getElementById('SubscriberForm_sameaddress').checked === true) {
            document.getElementById('SubscriberForm_facturationaddress_street').value = document.getElementById('SubscriberForm_deliveryaddress_street').value;
            document.getElementById('SubscriberForm_facturationaddress_postalCode').value = document.getElementById('SubscriberForm_deliveryaddress_postalCode').value;
            document.getElementById('SubscriberForm_facturationaddress_municipality').value = document.getElementById('SubscriberForm_deliveryaddress_municipality').value;
            document.getElementById('SubscriberForm_facturationaddress_country').value = document.getElementById('SubscriberForm_deliveryaddress_country').value;
        }
    });

    $(".invoiceDownload").click(function (e) {
        e.preventDefault();
        var $self = $(this);
        bootbox.setDefaults({
            locale: "nl"
        });

        bootbox.prompt("Wat is het bestelbon nummer?", function (result) {
            if (result !== null && result !== "") {
                $self.attr("href", $self.attr('href') + "/" + result);
            }
            document.location = $self.attr('href');
        });
    });
});
