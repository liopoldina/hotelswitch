$(function() {
    // front-end validation
    $("#booking_form").validate({
        rules: {
            first_name: {},
            last_name: {},
            email: {
                email: true
            },
            email_confirmation: {
                email: true,
                equalTo: "#email"
            },
            phone: {
                digits: true,
                maxlength: 25
            },
            card_name: {
                maxlength: 30
            },
            card_number: {
                creditcard: true
            },
            expiry_month: {
                range: [1, 12],
                digits: true
            },
            expiry_year: {
                range: [20, 50],
                digits: true
            },
            cvc: {
                rangelength: [3, 4],
                digits: true
            }
        },
        messages: {
            first_name: {
                required: "Please enter your first name"
            },
            last_name: {
                required: "Please enter your last name"
            },
            email: {
                required: "Please enter your email"
            },
            confirm_email: {
                required: "Please confirm your email",
                equalTo: "The emails don't match"
            },
            phone: {
                required: "Please enter your phone number"
            },
            card_name: {
                required: "Please enter the cardholder's name"
            },
            card_number: {
                required: "Please enter the credit card number"
            },
            expiry_month: {
                range: "Please enter the expiration month"
            },
            expiry_year: {
                range: "Please enter the expiration year"
            },
            cvc: {
                required: "Please enter the CVC-code"
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent(".input_wrapper"));
        }
    });
});
