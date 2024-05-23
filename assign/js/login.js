var Login = function() {
    "use strict";

    var runSetDefaultValidation = function() {
        $.validator.setDefault({
            errorElement : "span",
            errorClass : 'help-block',
            errorPlacement : function(error, element) {
                if(element.attr('type') == 'radio' || element.attr('type') == "checkbox"){
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } else if(element.attr('name') == 'card_expiry_mm' || element.attr('name') == 'card_expiry_yyyy'){
                    error.appendTo($(element).closest('.form-group').children('div'));
                } else {
                    error.insertAfter(element);
                    /* for other inputs, just perform default behavior */
                }
            },
            ignore : ':hidden',
            success : function(label, element){
                label.addClass('help-block valid');
                /* mark the current input as valid and display OK icon */
                $(element).closest('.form-group').removeClass('has-error');
            },
            highlight : function(element){
                $(element).closest('.help-block').removeClass('valid');
                /* display OK icon */
                $(element).closest('.form-group').addClass('has-error');
                /* add the Bootstrap error class to the control group */
            },
            unhightlight : function(element) {
                $(element).closest('.form-group').removeClass('has-error');
                /* set error class of the control group */
            }
        });
    };
    /* function login Validator */
    var runLoginValidator =  function() {
        var loginForm = $('.form-login');
        var errorHandlerlg = $('.errorHandler', loginform);
        loginForm.validate({
            rules : {
                username : {
                    minlength : 2,
                    required : true
                },
                password : {
                    minlength : 6,
                    required : true
                }
            },
            submitHandler : function(Form){
                errorHandlerlg.hide();
                loginForm.submit();
            },
            invalidHandler : function(event, validator) {
                errorHandlerlg.show();
            }
        });
    };
    /* function forgot validate */
    var runForgotValidator = function() {
        var forgotForm = $('.form-forgot');
        var errorHandlerfg = $('.errorHandler', forgotForm);
        forgotForm.validate({
            rules : {
                email : {
                    required : true
                }
            },
            submitHandler : function(form) {
                errorHandlerfg.hide();
                forgotForm.submit();
            },
            invalidHandler : function(event, validator) {
                errorHandlerfg.show();
            }
        });
    };
    /* function register validate */
    var runRegisterValidator = function() {
        var registForm = $('.form-register');
        var errorHandlerrg = $('.errorhandler', registForm);
        registForm.validate({
            rules : {
                fullname : {
                    minlength : 2,
                    required : true,
                },
                address : {
                    minlength : 2,
                    required : true
                },
                city: {
                    minlength :2,
                    required : true
                },
                gender : {
                    requried : true,
                },
                email : {
                    requried :  true,
                },
                password : {
                    minlength : 6,
                    required : true
                },
                confirmPassword : {
                    requried : true,
                    minlength : 5,
                    equalTo : '#password'
                },
                agree : {
                    minlength : 1,
                    required : true
                }
            },
            submitHandler : function(form){
                errorHandlerrg.hide();
                registForm.submit();
            },
            invalidHandler : function(event, validator) {
                errorHandlerrg3.show();
            }
        });
    };
    return { 
        /* main function to intiate template pages */
        init : function() {
            runSetDefaultValidation();
            runLoginValidatior();
            runForgotValidator();
            runRegisterValidator();
        }
    }
}
();