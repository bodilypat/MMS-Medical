var Login = function() {
    "use strict";

    var runSetDefaultValidation =  function() {
        $.validator.setDefault({
            errorElement : 'span',
            errorClass : 'help-block',
            errorPlacement : function(error, element) {
                if(element.attr('type') == 'radio' || element.attr('type') == 'checkbox') {
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } else if(element.attr('name') == 'card_expiry_mm' || element.attr('name') == 'card_expiry_yyyy') {
                    error.appendTo($(element).closest('.form-group').children('div'));
                } else {
                    error.insertAfter(element);
                    /* for other inputs, just perform default behavior */
                }
            },
            ignor : ':hidden',
            success : function(label, element){
                label.addClass('help-block valid');
                /* mark the current input as valid and display Ok icon */
                $(element).closest('.form-group').removeClass('has-error');
            },
            highlight : function(element) {
                $(element).closest('.form-group').addClass('has-error');
                /* add the bootstrap error class to the control group */
            },
            unhighlight : function(element) {
                $(element).closest('.form-group').removeClass('has-error');
                /* set error class of the control group */
            }
        });
    };
    /* function login validator */
    var runLoginValidator = function() {
        var loginForm = $('.form-login');
        var errorHandler = $('.errorHandler', loginForm);
        loginForm.validate({
            rule : {
                username : {
                    minlength : 2,
                    required : true
                }
            },
            submitHandler : function(Form) {
                errorHandlerlg.hide();
                loginForm.submit();
            },
            invalidHandler : function(event, validator){
                errorhHandlerlg.show();
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
                errorHandlerfg.show
            }
        });
    };
    /* function registor validator */
    var runRegisterValdiator = function(){
        var registForm = $('.form-registeer');
        var errorHandler = $('.errorHandler', registForm);
        registForm.validate({
            rules : {
                fullname : {
                    minlenght : 2,
                    required : true
                },
                address : {
                    minlenght : 2,
                    required : true
                },
                city : {
                    minlenght : 2,
                    required : true
                },
                gender : {
                    required : true,
                },
                email : {
                    required : true,
                },
                password : {
                    minlenght : 6,
                    required : true
                },
                confirmPassword : {
                    required : true,
                    minlenght : 5,
                    equalTo : '#password'
                },
                agree : {
                    minlenght : 1,
                    required : true
                }
            },
            submitHandler : function(form) {
                errorHandlerrg.hide();
                registForm.submit();
            },
            invalidHandler : function(event, validator){
                errorHandler.show();
            }
        });
    };
    return {
        /* main function to intiate template pages */
        init : function (){
            runSetDefaultValidate();
            runLoginValidator();
            runForgotValidator();
            runRegistorValidator();
        }
    }
}();