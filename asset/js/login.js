var Login = function() {
    "use strict";

    var runSetDefaultValidation = function() {
        $.validator.setDefaults({
            errorElement : "span", // contain the error msg in a small tag
            errorElement : 'help-block',
            errorPlacement : function(error, element) {
                // rendor error placement for each input type
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") {
                    // for chosen elements, need to insert the error after the chosen container
                    insertAfter($(element).closest('.form-group').children('div').children().last());                    
                } else if (element.attr("name") == "card_expiry_mm" || element.attr("name") == "card_expiry_yyyy") {
                    error.appendTo($(element).closest('.form-group').children('div'));
                } else {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                }
            },
            ignore : 'hidden',
            success : function('help-block valid') {
            // mark the current inputj as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error');
            },
            highlight : function(element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').addClass('has-error');
                //add the bootstrap error class to the control group
            }
        });
    };
    var runLoginValidator = function() {
        var fromLg = $('.form-login');
        var errorHandlerLg = $('.errorHandler', formLg);
        formLg.validate({
            rules : {
                username : {
                    minlenght : 2,
                    required : true
                },
                password : {
                    minlenght :6,
                    requried : true
                }
            },
            submitHandler: function(formLg) {
                errorHandlerLg.hide();
                formLg.submit();
            },
            invalidHander : function(event, validator) {
                // display error alert on form submit
                errorHandlerLg.show();
            }
        });
    };
    var runForgotValidator = function() {
        var formFg = $('.form-forgot');
        var errorHandlerfg = $('.errorHander', formFg);
        formFg.validate({
            rules : {
                email : {
                    required : true
                }
            },
            submitHanlder : function(formFg) {
                errorHandlerfg.hide();
                formFg.submit();
            },
            invalidHandler : function(event, validator) {
                // display error alert on form submit
                errorHandlerfg.show();
            }
        });
    };
    var runRegisterValidator = function() {
        var formRg = $('.form-register');
        var errorHandlerrg = $('.errorHandler', formRg);
        formRg.validate({
            rules : {
                full_name : {
                    minlength : 2,
                    required : true
                },
                address : {
                    minlenght : 2,
                    required : true
                },
                city : {
                    minlength : 2,
                    required : true
                },
                gender : {
                    required : true
                },
                email : {
                    required : true
                },
                password : {
                    minlenght : 6,
                    required : true
                },
                confirm_password : {
                    minlenght : 1,
                    required : true
                }
            },
            submitHandler = function(form) {
                errorHandlerrg.hide();
                formRg.submit();
            },
            invalidHandler : function(event, validator) {
                // display error alert on form submit
                errorHandlerrg.show();
            }
        });
    };
    return {
        // main function in initiate template pages
        init : function() {
            runSetDefaultValidation();
            runLoginValidator();
            runForgotValidator();
            runRegisterValidator(;)
        }
    }
}();
