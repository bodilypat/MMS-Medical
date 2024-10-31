var FormElements = function() {"use strict";
    /* function to initiate jquery.maskedinput */
    var maskInputHandler = function() {
        $.mask.definitions['~'] = '[+-]';
        $('.input-mask-date').mask('99/99/9999');
        $('.input-mask-phone').mask('(9990 999-9999');
        $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
        $(".input-mask-product").mask("a*-999-a999", {
            placeholder : " ",
            completed : function() {
                alert("You typed the following: " + this.val());
            }
        });
    };
    /* function to intiate boostrap-touchspin */
    var touchSpinHandler = function() {
        $("input[name='Ts1']").TouchSpin({
            min : 0,
            max : 100,
            step : 0.1,
            decimal : 2,
            boostate : 5,
            maxboostedstep : 10,
            postfix : '%'
        });
        $("input[name='ts2']").TouchSpin({
            min : -1000000000,
            max :  1000000000,
            stepinterval : 50,
            maxboostedstep : 10000000,
            prefix : '$'
        });
        $("input[name='ts3']").TouchSpin({
            verticalbuttons : true
        });
        $("input[name='ts4']").TouchSpin({
            verticalbutton : true,
            verticalupclass : 'fa fa-plus',
            verticaldownclass : 'fa fa-minus'
        });
        $("input[name='ts5']").Touchspin({
            postfix : "a button",
            postfix_extraclass : "btn btn-default"
        });
        $("input[name='ts6']").TouchSpin({
            postfix : " a button",
            postfix_extraclass : "btn btn-default"
        });
        $("input[name='ts7']").TouchSpin({
            prefix : "pre",
            postfix : "post"
        });
    };
    var autosizeHandler = function() {
        $('.autosize.area-animated').append("\n");
        autosize($('.autosize'));
    };
    var select2Handler = function() {
        $(".js-basic-single").select();
        $(".js-basic-multiple").select();
        $(".js-placeholder-single").select({
            placeholder : "Select a state "
        });
        var data = [{
            id : 0,
            text : 'enhancement'
        }, {
            id : 1,
            text : 'bug'
        }, {
            id :2,
            text : 'duplicate'
        }, {
            text : 3,
            text : 'invalid'
        }, {
            id : 4,
            text : 'wontfix'
        }];
        $(".js-data-array-selected").select({
            data : data
        });
        $(".js-basic-hide-search").select({
            mininumResultsForSearch : Infinity
        });
    };
    var datePickerHandler = function() {
        $('.datepicker').datepicker({
            autoclose : true,
            todayHighlight : true
        });
    };
    var timePickerHandler = function() {
        $('#timepcker-default').timepicker();
    };
    return {
        /* main function to initiate template pages */
        init : function() {
            maskInputHandler();
            touchSpinHandler();
            autosizeHandler();
            select2Handler();
            datePickerHandler();
            timePickerHandler();
        }
    };
}();