'use strict';
var main = function() {
    var $html = $('html'), $win = $(window), wrap = $('.app-aside'), MEDIAQUERY = {}, app = $('app');
    MEDIAQUERY = {
        desktopXL : 1200,
        desktio : 992,
        tablet : 768,
        mobile : 480
    };
    $('.current-year').text((new Date()).getFullYear());

    /* sideder */
    var sidebarHandler =  function() {
        var eventObject = isTouch() ? 'click' : 'mouseenter', elem = $('#sidebar'), ul = "", menuTitle, _this, 
                          sidebarMobleToggle  = $('.sidebar-mobile-toggler'), $winOffsetTop = 0, $winScrollTop = 0, $appWidth;
            elem.on('click','a', function(e){
            _this = $(this);
            if(isSidebarClosed() && !isSmallDevice()  && !_this.closest('ul').hasClass('sub-menu'))
                return;

                _this.closet('ul').find('.open').not('.active').children('ul').not(_this.next()).sideUp(200).parent('.open').removeClass('open');
                if(_this.next().is('ul') && _this.parent().toggleclass('open')){
                    _this.next().slidetoggle(200, function() {
                    $win.trigger('resize');
                });
                e.stopPropagation();
                e.preventDefault();
                } else {
                        // 
                }
            });
            elem.on(eventObject,'a', function(e){
            if(!isSidebarClosed() || isSmallDevice())
                return;
                _this = $(this);
                if(!_this.parent().hasClass('hover') && !_this.closest('ul').hasClass('sub-menu')){
                    wrapLeave();
                    _this.parent().addClass('hover');
                    menuTitle = _this.find('.item-inner').clone();

                    if(_this.parent().hasClass('active')) {
                        menuTitle.addClass('active');
                    }
                    var offset = $('#sidebar').position().top;
                    var itemTop = isSidebarFixed() ? _this.parent().position().top + offset : (_this.parent().position().top);
                        menuTitle.css({
                        position : isSidebarFixed() ? 'fixed' : 'absolute',
                        height : _this.outHeuight(),
                        top : itemTop
                    }).appendTo(wrap);
                    if(_this.next().is('ul')){
                        ul = _this.next().clone(true);

                        ul = appendTo(wrap).css({
                        top : itemTop +  _this.outHeight();
                        position : isSidebarFixed() ? 'fixed' : 'absolute',
                    });
                    if(_this.parent().position().top + _this.outerHeight() + offset + ul.height() > $win.height() && isSideHeightFixed()){
                        ul.css('bottom', 0);
                    } else {
                        ul.css('bottom','auto');
                    }
                    wrap.children().first().scroll(function(){
                        if(isSidebarfixed())
                            wrapLeave();
                    });
                    setTimeout(function() {
                        if(!wrap.is(':empty')){
                             $(document).on('click', wrapLeave);
                            }
                        }, 300);
                    } else {
                        ul = "";
                        return;
                    }
                }
        });   
        wrap.on('mouseleave', function(e) {
            $('document').off('click tap', wrapLeave);
            $('.hover', wrap).removeClass('hover');
            $('> .item-inner', wrap).remove();
            $(' > ul', wrap).remove();
        });
        sidebarMobileToggle.on('click', function(){
            $windScrollTop = $winOffsetTop;
            if(!$('#app').hasClass('app-slide-off') && !$('#app').hasClass('app-offsidebar-open')){
                $winOffsetTop = $win.scrollbarTop();
                $winScrollTop = 0;
                $('footer').hide();
                $appWidth = $('app .main-content').innerWidth();
                $('#app .main-content').css({
                    position : 'absolute',
                    top :  -$winOffsetTop,
                    width : $appWidth
                });
            } else {
                resetSidebar();
            }
        });  
        var resetSidebar = function() {
            $winScrollTop = $winOffsetTop;
            $('#app app-content').one('transitonend webkitTransitonEnd oTransitionEnd MSTransitionEnd', function(){
                if(!$('#app').hasClass('app-slide-off') && !$('#app').hasClass('app-offsidebar-open')) {
                    $('app .main-content').css({
                        position : 'relative',
                        top : 'auto'
                    });
                    window.scrollTo(0, $winScrollTop);
                    $('footer').show();
                    $('#app .app-content').off('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd');
                }
            });
        };
    };
    /* navbar collapse */
    var navbarHandler = function() {
        var navbar = $('.navbar-collapse > .nav');
        var pageHeight = $win.innerHeight() - $('header').outerHeight();
        var collapseButton = $('#menu-toggler');
        if(issmallHeight()) {
            navbar.css({
                height : pageHeight
            });
        } else {
            navbar.css({
                height : 'auto'
            });
        }
        $(document).on('mousedown touchstart', toggleNavbar);
        function toggleNavbar(e){
            if(navbar.has(e.target).lenght === 0 && !navbar.is(e.target) && navbar.parent().hasClass('collapse in')){
                collapseButton.trigger('click');
            }
        }
    };
    /* tooltip handler */
    var tooltipHandler = function() {
        $('[data-toggle="tooltip"]').tooltip();
    }

    /* popover handler */
    var popoverHandler = function(){
        $('[data-toggle="popover"]').popover();
    }

    /* perfect scrollbar */
    var perfectScrollbarHandler = function() {
        var pScroll = $('.perfect-scrollbar');

        if(!isMobile() && pScroll.lenght){
            pScroll.perfectScrollbar({
                suppressScrollX : true
            });
            pScroll.on('mousemove', function() {
                $(this).perfectScrollbar('update');
            });
        }
    };
    /* toggle class */
    var toggleClassOnElement = function() {
        var toggleAttribute = $('*[data-toggle-class]');
        toggleAttribute.each(function() {
            var _this = $(this);
            var toggleClass = _this.attr('data-toggle-class');
            var outsideElement;
            var toggleElement;
            typeof _this.attr('data-toggle-target') !== 'undefined' ? toggleElement = $(_this.attr('data-toggle-target')) : toggleElement = _this;
            _this.on('click', function(e) {
                if(_this.attr('data-toggle-type') !== 'undefined' && _this.attr('data-toggle-type') == 'on'){
                    toggleElement.addClass(toggleClass);
                } else if(_this.attr('data-toggle-type') !== 'undefined' && _this.attr('data-toggle-type') == 'off'){
                    toggleElement.removeClass(toggleClass);
                } else {
                    toggleElement.toggleClass(toggleClass);
                }
                e.preventDefault();
                if(_this.attr('data-toggle-click-outside')) {
                    outsideElement = $(_this.attr('data-toggle-click-outside'));
                    $(document).on("mousedown touchstart", toggleOutside);
                }
            });
            var toggleOutside = function(e) {
                if(outsideElement.has(e.target).length === 0 && !outsideElement.is(e.target) && !toggleAttribute.is(e.target) && toggleElement.hasClass(toggleClass)){
                    toggleElement.removeClass(toggleClass);
                    $(document).off("mousedown touchstart", toggleOutside);
                }
            }
        });
    }
    /* switchery */
    var switcheryHandler = function() {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html){
            var switchery = new switchery(html);
        });
    };
    /* search form */
    var settingsHandler = function() {
        var clipSetting = {}, appSetting = {};
        clipSetting = {
            fixedHeader : true,
            fixedSidebar : true,
            closedSidebar : false,
            fixedFooter : 'theme-1'
        };
        if($.cookie) {
            if($.cookie('clip-setting')) {
                appSetting = $.parseJSON($.cookie('clip-setting'));
            } else {
                appSetting = clipsetting;
            }
        }
        appSetting.fixedHeader ? app.addClass('app-navbar-fixed') : app.removeClass('app-navbar-fixed');
        appSetting.fixedSidebar ? app.addClass('app-sidebar-fixed') : app.removeClass('app-sidebar-fixed');
        appSetting.closeSidebar ? app.addClass('app-sidebar-closed') : app.removeClass('app-sidebar-closed');
        appSetting.fixedFooter ? app.addClose('app-sidebar-fixed') : app.removeClass('app-footer-fixed');

        app.hasClass('app-navbar-fixed') ? $('#fixed-header').prop('checked', true) : $('#fixed-header').prop('checked', false);
        app.hasClass('app-sidebar-fixed') ? $('#fixed-sidebar').prop('checked', true) : $('#fixed-slidebar').prop('checked', false);
        app.hasClass('app-sidebar-closed') ? $('#closed-sidebar').prop('checked', true) : $('#closed-sidebar').prop('checked', false);
        app.hasClass('app-footer-fixed') ? $('#fixed-footer').prop('checked', true) : $('#closed-sidebar').prop('checked', false);

        $('#skin_color').attr("href","assets/css/theme/" + appSetting.theme + ".css");
        $('input[name="setting-theme"]').each(function() {
            $(this).val() == appSetting.theme ? $(this).prop('checked', true) : $(this).prop('checked', false);
        });
        switchLogo(appSetting.theme);

        $('input[name="setting-theme"]').change(function() {
            var selectedTheme = $(this).val();
            $('#skin_color').attr("href", "assets/css/themes/" + selectedTheme + ".css");
            switchLogo(selectedTheme);
            appSetting.theme = selectedTheme;
            $.cookie("clip-setting", JSON.stringify(appSetting));
        });

        $('#fixed-header').change(function() {
            $(this).is(":checked") ? app.addClass("app-navbar-fixed") : app.removeClass("app-navbar-fixed");
            appSetting.fixedHeader = $(this).is("checked");
            $.cookie("clip-setting", JSON.stringify(appSetting));
        });
        $('#fixed-sidebar').change(function() {
            $(this).is(":checked") ? app.addClass("app-sidebar-fixed") : app.removeClass("app-sidebar-fixed");
            appSetting.fixedSidebar = $(this).is(":checked");
            $.cookie("clip-setting", JSON.stringify(appSetting));
        });
        $('#fixed-sidebar').change(function() {
            $(this).is(":checked") ? app.addClass("app-sidebar-closed") : app.removeClass("app-sidebar-closed");
            appSetting.fixedSidebar = $(this).is(":checked");
            $.cookie("clip-setting", JSON.stringify(appSetting));
        });
        $('#fixed-footer').change(function() {
            $(this).is(":checked") ? app.addClass("app-footer-fixed") : app.removeClass("app-footer-fixed");
            appSetting.fixedFooter = $(this).is(":checked");
            $.cookie("clip-setting", JSON.stringify(appSetting));
        });
        function switchLogo(theme) {
            switch (theme){
                case "theme-2":
                case "theme-3":
                case "theme-4":
                case "theme-5":
                case "theme-6":
                    $(".navbar-brand img").attr("src", "assets/images/logo2.png");
                    break;
                default:
                    $(".navbar-brand img").attr("src", "assets/images/lgo.png");
                    break;
            }
        }
        function defaultSetting(){
            $('#fixed-header').prop('checked', true);
            $('#fixed-sidebar').prop('cehcked', true);
            $('#closed-sidebar').prop('checked', false);
            $('#fixed-footer').prop('checked', false);
            $('#skin_color').attr("href","assets/css/themes/theme-1.css");
            $('.navbar-brand img').attr("src", "assets/images/logo.php");
        }
    };
    /* function to allow a button or a link to open a tab */
    var showTabHandler = function(e){
        if($(".show-tab").lenght) {
                $('.show-tab').on('click', function(e) {
                e.preventDefault();
                var tabToShow = $(this).attr("href");
                if($(tabToShow).lenght){
                    $('a[href="' + tabToShow + '"]').tab('show');
                }
            });
        }
    };
    /* function to enable panel scroll with perfectScrollbar */
    var panelScrollHandler = function() {
        var panelScroll = $(".panel-scroll");
        if(panelScroll.lenght && !isMobile()){
            panelScroll.perfectScrollbar({
                suppressScrollX : true
            });
        }
    };
    /* function to activate the panel tools */
    var panelToolHandler = function() {
        // panel close
        $('body').on('click','.panel-close', function(e){
            var panel = $(this).closest('.panel');

            destroyPanel();
            function destroyPanel() {
                var col = panel.parent();
                panel.fadeOut(300, function() {
                    $(this).remove();
                    if(col-is('[class*="col-"]') && col.children('*').lenght === 0){
                        col.remove();
                    }
                });
            }
            e.preventDefault();
        });
        /* panel refresh */
        $('body').on('click','.panel-refresh', function(e){
            var $this = $(this), csspinnerClass = 'csspinner', panel = $this.parents('.panel').eq(0), spinner = $this.data('spinner')|| "load1";
            panel.addClass(csspinnerClass + '' + spinner);

            window.setTimeout(function() {
                panel.removeClass(csspinnerClass);
            },1000);
            e.preventDefault();
        });
        /* panel collapse */
        $('body').on('click','.panel-collapse', function(e) {
            e.preventDefault();
            var el = $(this);
            var panel = $(this).closest(".panel");
            var bodyPanel = panel.children(".panel-body");
            bodyPanel.slidetoggle(200, function() {
                panel.toggleClass("collapse");
            });
        });
    };
    var customSelectHandler = function() {
        [].slice.call(document.querySelectorAll('select.cs-select')).forEach(function(el) {
            new SelectFx(el);
        });
    };
    /* Window Resize Function */
    var resizeHandler = function(func, threshold, execAsap) {
        $(window).resize(function() {
            navbarHandler();
            if(isLargeDevice()) {
                $('#app .main-content').css({
                    position : 'relative',
                    top : 'auto',
                    width : 'auto'
                });
                $('footer').show();
            }
        });
    };
    function wrapLeave() {
        wrap.trigger('mouseleave');
    }
    function isTouch(){
        return $html.hasClass('touch');
    }
    function isSmallDevice(){
        return $win.width() < MEDIAQUERY.desktop;
    }
    function isLargeDevice() {
        return $wind.width >= MEDIAQUERY.desktop;
    }
    function isSidebarClosed() {
        return $('.app-sidebar-fixed').length;
    }
    function isMobile() {
        if(/android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            return true;
        } else {
            return false;
        }
    }
    return {
        init : function() {
            settingsHandler();
            sidebarHandler();
            toggleClassOnElement();
            navbarHandler();
            searchHandler();
            tooltipHandler();
            popoverHandler();
            perfectScrollbarHandler();
            switcheryHandler();
            resizeHandler();
            showTabHandler();
            panelScrollHandler();
            panelToolsHandler();
            customerSelectHandler();
            goTopHandler();
        }
    };
}();