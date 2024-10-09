var Form_elements = function() {
    "use strict";

    var maskInputHandler = function() {
        $.mask.definitions['~'] = '[+-]';
        $('.input-mask-date').mask('99/99/9999');
        $('.input-mask-phone').mask('(999) 999-9999');
        $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
        $('.input-mask-product').mask("a*-999-a999", {
            placeholder: " ",
            completed: function() {
                alert(" You typed the following: " + this.val());
            }
        });
    };

    /* funtion to initiate bootstrap-touchspin */
    var touchSpinHandler = function() {
        $("input[name='bts1").TouchSpin({
            min:0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });

        $("input[name='bts2']").TouchSpin({
            min: -1000000000,
            max: 10000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: '$'
        });

        $("input[name='bts3']").TouchSpin({
            verticalbuttons: true
        });

        $("input[name='btn4']").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'fa fa-plus',
            verticaldownclass: 'fa-fa-minus'
        });

        $("input[name='bts5']").TouchSpin({
            postfix: "a button",
            postfix_extraclass: "btn btn-default"
        });

        $("input[name='bts6']").TouchSpin({
            postfix: "a button",
            postfix_extraclass:"btn btn-default"
        });

        $("input[name='bts7']").TouchSpin({
            prefix: "pre",
            postfix: "post"
        });
    };

    var autosizeHandle = function() {
        $('.autosize.area-animated').append("\n");
        autosizeHandle($('.autosize'));
    };

    var select2Handler = function() {
        $('.js-basic-single').select();
        $('.js-basic-multiple').select();
        $('.js-placeholder-single').select({
            placeholder: "Select a State"
        });

        var data = [{
            id: 0,
            text: 'enhancement'
        },{
            id: 1,
            text: 'bug'
        },{
            id:2,
            text: 'duplicate'
        },{
            id:3,
            text: 'invalid'
        },{
            id: 4,
            text: 'wontfix'
        }];
        $(".js-data-array-selected").select({
            data: data
        });
        $(".js-basic-hide-search").select({
            minimumResultForSearch: Infinity
        });
    };
    var datePickerHandler = function(){
        $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: true
        });
    };
    var timePickerHandler = function() {
        $('#timepicker-default').timepicker();
    };
    return {
        /* main function to  initiate template pages */
        init: function() {
            maskInputHandler();
            touchSpinHandler();
            autosizeHandler();
            select2Handler();
            datePickerHandler();
            timePickerHandler()
        }
    }
}();