var Login = function() {
    "user strict";

    var runSetValidation = function(){
        $.validation.setDefault({
            errorElement: "span", /* containe error msg in a small tag */
            errorClass: 'help-block',
            errorPlacement : function(error, element){ /* render error placement  */
                if(element.attr("type") == "radio" || element.attr("type") == "checkbox") { 
                    /* chosen element, need to insert  */
                } else if (element.attr('name') == "card_expiry_mm" || element.attr('name') == "card_expiry_yyyy" ) {
                    error.appendTo($(element).closest('.form-group').children('div'));
                } else {
                    error.insertAfter(element);
                    /* for other inputs */
                }
            },
            ignore : ':hidden',
            success : function(label, element) {
                label.addClass('help-block valid'); 
                /* current input as valid and display OK icon */
                $(element).closest('.form-group').removeClass('has-error');
            },
            highlight : function(element) {
                $(element).closest('.help-group').addClass('has-error'); 
                /* add Bootstrap error class control group */
            },
            unhighlight : function(element) { 
                /* revert change done by hightlight */
                $(element).closest('.form-group').removeClass('has-error'); /* set error class to the control group */
            }
        });
    };
    var runLoginValidator = function() {
        var loginForm = $('.form-login');
        var errorHandlerlg = $('.errorHandler', form);
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
            submitHandler : function(form) {
                errorHandler.hide();
                loginForm.submit();
            },
            invalidHandler : function(event, validator) { /* display error alear on form submit */
                errorHandker.show();
            }
        });
    };
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
            invalidHandler : function(event, validator) { /* display error alert on form submit */
                errorHandlerfg.show();
            }
        });
    };
    var runRegisterValidator = function() {
        var registForm = $('.form-register');
        var errorHandlerrg = $('.errorHandler', registForm);
        registForm.validate({
            rules : {
                fullname : {
                    minlength : 2,
                    required : true
                },
                address: {
                    minlength : 2,
                    required : true
                },
                city : {
                    minlength : 2,
                    required : true,
                },
                gendor: {
                    required : true
                },
                email : {
                    required : true
                },
                password : {
                    mainlength : 6,
                    required : true
                },
                conforimPassword : {
                    required : true,
                    minlength : 5,
                    equalTo : "#password"
                },
                agree: {
                    minlength : 1,
                    requried : true
                }
            },
            submitHandler : function(form) {
                errorHandlerrg.hide();
                registForm.submit();
            },
            invalidHandler : function(event, validator) { /* display error alert on form submit */
                errorHandlerrg.show();
            }
        });
    };
    return { /* main function to initiate template pages */
        init : function() {
            runSetValidation();
            runLoginValidator();
            runForgotValidator();
            runRegisterValidator();
        }
    }
}
();