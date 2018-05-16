$(function(){

    $("#tag2").hide();

    $(".feedback_button").click(function(){
        $('.form').slideToggle();
    });

});

$(document).ready( function() {
    $('#holr-form').submit(function(event) {


        event.preventDefault();

        var $form = $('#holr-form');

        var action = $form.attr('action');

        if(!$form.valid()) return false;

        // Get the form data
        var formData = {
           'name'   : $('#holr_name').val(),
           'email'  : $('#holr_email').val(),
           'message': $('#holr_details').val()
        };

        // Process the form
        $.ajax({
            url: 'https://holr.help/holr/' + action,
            type: "GET",
            data: formData,
            dataType: 'jsonp',
            callback: 'callback',
            success: function(data) {
                     $("#tag1").hide();
                     $("#nameField").hide();
                     $("#emailField").hide();
                     $("#detailsField").hide();
                     $("#holr_button").hide();
                     $("#tag2").show();

                     console.log(data.response);
            }
        });

    });
});