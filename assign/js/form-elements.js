var formElements = function(){ "use strict";

    /* function to intiate jquery.maskedinput */
    var maskInputHandler = function() {
        $.mask.definitions['~'] = '[+-]';
        $('.input-phone').mask('99/99/9999');
        $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
        $('.input-mask-product').mask('a*-999-a999', {
            placeholder : " ",
            completed: function() {
                alert("You typed the following: " + this.val());
            }
        });
    };
    /* function to initiate bootstrap-touchspin */
    var touchSpinHandler = function(){
        $("input[name='demo1']").TouchSpin({
            min : 0,
            max : 100,
            step : 0.1,
            decimal : 2,
            boostat : 5,
            maxboostredstep : 10,
            postfix : '%'
        });
        $("input[name='demo2']").TouchSpin({
            min : -1000000000,
            max : 10000000000,
            stepinterval : 50,
            maxboostedstep : 10000000,
            prefix : '$'
        });
        $("input=[name='demo3']").TouchSpin({
            verticalbuttons : true,
        });
        $("input[name='demo4']").TouchSpin({
            verticalbuttons : true,
            verticalupclass : 'fa fa-plus'
            verticaldownclass : 'fa fa-minus'
        });
        $("input[name='demo5']").TouchSpin({
            posifix : " a button",
            postfix_extraclass : "btn btn-default"
        });
        $("input[name='demo6']").TouchSpin({
            prefix : "pre",
            postfix : "post"
        });
    };
    var autosizeHandler = function() {
        $('.autosize.area-animated').append("\n");
        autosizeHandler($('.autosize'));
    };
    var selected2Handler = function() {
        $('.js-example-basic-single').select2();
        $('.js-example-basic-multiple').select2();
        $('.js-example-placeholder-single').select2({
            placeholder : "Select a state"
        });
        var data = [{
            id : 0,
            text : 'enhancement'
        },{
            id : 1,
            text : 'bug'
        }, {
            id : 2,
            text : 'duplicate'
        }, {
            id : 3,
            text : 'wontfix'
        }];
        $('.js-example-data-array-selected').select2({
            data : data 
        });
        $('.js-example-basic-hide-search').select2({
            minnimumResultsForSearch : Infinity
        });
    };
    var datePickerHandler = function() {
        $('.datepicker').datepicker({
            autoclose : true,
            todayHighlight : true
        });
        $('.format-datepicker').datepicker({
            format : "M, d yyyy",
            todayHighlight : true
        });
    };
    var timePickerHandler = function() {
        $('#timepicker-default').timepicker();
    };
    return {
        /* main function to initiate template pages */
        init : function {
            maskInputHandler();
            touchSpinHandler();
            autosizeHandler();
            selected2Handler();
            datePickerHandler();
            timePickerHandler();
        }
    };
} ();
