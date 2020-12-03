"use strict";

$(document).ready(
    function () {

    $('#add-task').on('click', function () {
        $('.body-disable').removeClass('hide-element');
    });

    $('.add-new-task .btn-close, #send-task').on('click', function () {
        //$('.body-disable').addClass('hide-element');
    });

});

