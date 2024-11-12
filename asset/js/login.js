var Login = function() {
    "use strict";
    var runValidation = function() {
        $.validation.setDefault({
            errorElement: "span",
            errorClass: "help-block",
            errorPlacement : function(error, element) {
                if(element.attr('type') == "radio" || element.attr('type') == "checkbox"){
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } else if(element.attr('name') == 'card_expiry_mm' || element.attr('name') == 'card_expiry_yyyy') {
                    error.appendTo($(element).closest('.form-group').children('div'));
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: ':hidden',
            success: function(label, element) {
                label.addClass('help-block valid');
                $(element).closest('.form-group').removeClass('has-error');
            },
            hightlight: function(element) {
                $(element).closest('.form-group').removeClass('valid');
                $(element).closest('.form-group').add('has-error');
            },
            unhightlight : function(element){
                $(element).closest('form-group').removeClass('has-error');
            }
        });
    };
    var runLoginValidator = function() {
        var formlg = $('.form-login');
        var errorHandlerlg = $('.errorHandler', form);
        formlg.validate({
            rule: {
                username : {
                    mainlength : 2,
                    required : ture 
                },
                password : {
                    minlength: 6,
                    required: true
                }
            },
            submitHandler : function(form) {
                errorHandlerlg.hide();
                formlg.submit();
            },
            invalidHandler: function(event, validator){
                errorHandler.show();
            }
        })
    };
    var runForgotValidator = function() {
        var formfg = $('.form-forgot');
        var errorHandlerfg = $('.errorHandler', formfg);
        formfg.validate({
            rule: {
                email : {
                    required: true
                }
            },
            submitHandler: function(form) {
                errorHandlerfg.hide();
                formfg.submit();
            },
            invalidHandler: function(event, validator) {
                errorHandlerfg.show();
            }
        });
    };
    var registValidator = function() {
        var formrg = $('.form-register');
        var errorHandlerrg = $('.errorHandler', formrg);
        formrg.validate({
            rules : {
                fullName: {
                    minlenght: 2,
                    required : ture
                },
                address : {
                    minlength: 2,
                    required: true
                },
                city : {
                    minlength: 2,
                    required: true,
                },
                gender: {
                    required: true
                },
                email: {
                    required: true
                },
                password: {
                    minlength: 6,
                    required: true
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                }
            },
            submitHandler: function(form){
                errorHandlerrg.hide();
                formrg.submit();
            },
            invalidHandler: function(even, validator) {
                errorHandlerrg.show();
            }
        });
    };
    return {
        init: function() {
            runValidation();
            runLoginValidator();
            runForgotValidator();
            runRegistorValidator();
        }
    }
}();