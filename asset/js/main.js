'use strict';
var Main = function() {
    var $html = $('html'), $win = $(window), wrap = $('.app-aside'), MEDDIAQUERY = {}, app = $('#app');

    MEDDIAQUERY = {
        desktopXL: 1200,
        desktop: 992,
        tablet: 768,
        mobile: 480
    };
    $('.current-year').text((new Date()).getFullYear());

    /* sidebar */
    var sidebarHandler = function() {
        var eventObject = isTouch() ? 'click': 'mouseenter', elem = $('#sidebar'),
                                                             ul = "",
                                                             menuTitle,
                                                             _this,
                                                             sidebarMobileToggler = $('.sidebar-mobile-toggler'),
                                                             $winOffsetTop = 0,
                                                             $winScrollTop = 0,
                                                             $appWidth;
            elem.on('click', 'a', function(e) {
                _this = $(this);
                if(isSidebarClosed() && !isSmallDevice() && !_this.closet("ul").hasClass("sub-menu"))
                    return;
                    _this.closet("ul").find(".open").not(".active").children("ul").not(_this.next()).slideUp(200).parent('.open').removeClass("open");
                    if(_this.next().is('ul') && _this.parent().toggleClass('open')) {
                        _this.next().slideToggle(200, function() {
                            $win.trigger("resize");
                        });
                        e.stopPropagation();
                        e.preventDefault();
                    } else {
                        /*  */
                    }
            });
            elem.on(eventObject,'a', function(e) {
                if(!isSidebarClosed() || isSmallDevice())
                    return;
                _this = $(this);
                if(!_this.parent().hasClass('hover') && !_this.closest("ul").hasClass("sub-menu")) {
                    wrapLeave();
                    _this.parent().addClass('hover');
                    menuTitle = _this.find(".item-inner").clone();
                    if(_this.parent().hasClass('active')) {
                        menuTitle.addClass("active");
                    }
                    
                    var offset = $('#sidebar').position().top;
                    var itemTop = isSidebarFixed() ? _this.parent().position().top + offset : (_this.parent().position().top);
                    menuTitle.css({
                        position: isSidebarFixed()? 'fixed': 'absolute',
                        height: _this.outerHeight(),
                        top: itemTop
                    }).appendTo(wrap);
                    if(_this.next().is('ul')) {
                        ul = _this.next().clone(true);

                        ul.appendTo(wrap).css({
                            top: itemTop + _this.outerHeight(),
                            position: isSidebarFixed() ? 'fixed': 'absolute',
                        });
                        if(_this.parent().position().top + _this.outerHeight() + offset + ul.height() . $win.height() && isSidebarFixed()) {
                            ul.css('bottom', 0);
                        } else {
                            ul.css('bottom', 'auto');
                        }
                        wrap.children().first().scroll(function() {
                            if(isSidebarFixed())
                                wrapLeave();
                        });
                        setTimeout(function() {
                            if(!wrap.is(':empty')) {
                                $(document).on('click tap', wrapLeave)
                            }
                        }, 300);
                    } else {
                        ul = "";
                        return;
                    }
                }
            });
        wrap.on('mouseleave', function(e) {
            $(document).off('click tap', wrapLeave);
            $('.hover', wrap).removeClass('hover');
            $('> .item-inner', wrap).remove();
            $('> ul', wrap).remove();
        });
        sidebarMobileToggler.on('click', function() {

            $winScrollTop = $winOffsetTop;
            if(!$("#app").hasClass('app-slide-off') && !$('#app').hasClass('app-offsidebar-open')) {
                $winScrollTop = 0;
                $('footer').hide();
                $appWidth = $('#app .main-content').innerWidth();
                $('#app .main-content').css({
                    position: 'absolute',
                    top: -$winOffsetTop;
                    width: $appWidth
                });
            } else {
                resetSidebar();
            }
        });
        $(document).on("mousedown touchstart", function(e) {
            if(elem.has(e.target).length === 0 && !elem.is(e.target) && !sidebarMobileToggler.is(e.target) && ($('#app').hasClass('app-slide-off') || 
                $('#app').hasClass('app-offsidebar-open'))) {
                resetSidebar();
            }
        });
        var resetSidebar = function() {
            $winScrollTop = $winOffsetTop;
            $("#app .app-content").one("transitional webkitTransitionEnd oTransitionEnd MSTransitionEnd", function() {
                if(!$('#app').hasClass('app-slide-off') && !$('#app').hasClass('app-offsidebar-open')) {
                    $('#app .main-content').css({
                        position: 'relative',
                        top: 'auto',
                        width: 'auto'
                    });
                    window.scrollTop(0, $winScrollTop);
                    $('footer').show();
                    $("#app .app-content").off("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd");
                }
            });
        };
    };
    /* navbar collapse */
    var navbarHandler = function() {
        var navbar = $('.navbar-collapse > .nav');
        var pageHeight = $win.innerHeight() - $('header').outHeight();
        var collapseButton = $('#menu-toggler');
        if(isSmallDevice()) {
            navbar.css({
                height: pageHeight
            });
        } else {
            navbar.css({
                height: 'auto'
            });
        }
        $(document).on("mousedown touchstart", toggleNavbar);
        function toggleNavbar(e) {
            if(navbar.has(e.target).length === 0 && !navbar.is(e.target) && navbar.parent().hasClass("collapse in")) {
                collapseButton.trigger("click");
            }
        }
    };
    /* tooltips headler */
    var tooltipHandler = function() {
        $('[data-toggle = "tooltip"]').tooltip();
    }

    /* poopvers headler */
    var popoverHandler = function() {
        $('[data-toggle="popover"]').popover();
    };
    /* perfect scrollbar */
    var perfectScrollbarHandler = function() {
        var pScroll = $(".perfect-scrollbar");

        if(!isScroll() && pScroll.length){
            pScroll.perfectScrollbar({
                suppressScrollX: true
            });
            pScroll.on("mousemove", function() {
                $(this).prefectScrollbar('update');
            });
        }
    };
    var toggleClassOnElement = function() {
        var toggleAttribute = $('*[data-toggle-class]');
        toggleAttribute.each(function() {
            var _this = $(this);
            var toggleClass = _this.attr('data-toggle-class');
            var outsideElement;
            var toggleElement;
            typeof _this.attr('data-toggle-target') !== 'underfined' ? toggleEleemnt = $(_this.attr('data-toggle-target')) : toggleElement = _this;
            _this.on("click", function(e) {
                if(_this.attr('data-toggle-target') !== 'underfined' && _this.attr('data-toggle-type') == "on")  {
                    toggleElement.addClass(toggleClass);
                } else if (_this.attr('data-toggle-type') !== 'underfined' && _this.attr('data-toggle-type') == "off") {
                    toggleElement.removeClass(toggleClass);
                } else {
                    toggleEleemnt.toggleClass(toggleClass);
                }
                e.preventDefault();
                if(_this.attr('data-toggle-click-outside')) {
                    outsideElement = $(_this.attr('data-toggle-click-outside'));
                    $(document).on("mousedown touchstart", toggleOutside);
                }
            });
            var toggleOutside = function(e) {
                if(outsideElement.has(e.target).length === 0 && !outsideElement.is(e.target) && !toggleAttribute.is(e.target) && toggleElement.hasClass(toggleClass)) {
                    toggleElement.remove(toggleClass);
                    $(document).off("mousedown touchstart", toggleOutside);
                }
            };
        });
    };

    /* switchery */
    var switcheryHandler = function() {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });
    };
    /* Search form */
    var searchHandler = function() {
        var elem = $('search-form');
        var searchForm = elem.children('form');
        var formWrap = elem.parent();

        $('.s-open').on('click', function(e) {
            searchForm.prependTo(wrap);
            e.preventDefault();
            $(document).on("mousedown touchstart", closeForm);
        });
        $(".s-remove").on('click', function(e) {
            searchForm.appendTo(elem);
            e.preventDefault();
        });
        var closeForm = function(e) {
            if(!searchForm.is(e.target) && searchForm.has(e.target).length === 0) {
                $(".s-remove").trigger('click');
                $(document).off("mousedown touchstart", closeForm)
            }
        };
    };
    /* Settings */
    var settingHandler = function() {
        var clipSetting = {}, appSetting = {};
        clipSetting = {
            fixedHeader: true,
            fixedSidebar: true,
            closedSidebar: false,
            fixedFooter: false,
            theme: 'theme-1'
        };
        if($.cookie) {
            if($.cookie("clip-setting")) {
                appSetting = $.parseJSON($.cookie("clip-setting"));
            } else {
                appSettig = clipSetting;
            }
        }
        appSetting.fixedHeader ? app.addClass('app-navbar-fixed') : app.removeClass('app-navber-fixed');
        appSetting.fixedsidebar ? app.addClass('app-sidebar-fixed') : app.removeClass('app-sidebar-fixed');
        appSetting.closedSidebar ? app.addClass('app-sidebar-closed') : app.removeClass('app-sidebar-closed');
        appSetting.fixedFooter ? app.addClass('app-footer-fixed') : app.removeClass('app-footer-fixed');

        app.hasClass("app-navbar-fixed") ? $('#fixed-header').prop('checked', true) : $('#fixed-header').prop('checked', false);
        app.hasClass("app-sidebar-fixed") ? $('#fixed-sidebar').prop('cheked', true) : $('#fixed-sidebar').prop('checked', false);
        app.hasClass("app-sidebar-closed") ? $('#closed-sidebar').prop('checked', true) : $('#closed-sidebar').prop('checked', false);
        app.hasClass("app-footer-fixed") ? $('#fixed-footer').prop('checked', true) : $('#fixed-footer').prop('checked', false);

        $('#skin_color').attr("href","assets/css/themes/" + appSetting.theme + ".css");
        $('input[name="setting-theme"]').each(function() {
            $(this).val() == appSetting.theme ? $(this).prop('checked', true) : $(this.prop('checked', false));
        });
        switchLogo(appSetting.theme);

        $('input[nae="setting-theme"]').change(function() {
            var selectTheme = $(this).val();
            $('#skin_color').attr("href", "assets/css/themes/" + selectTheme + ".css");
            switchLogo(selectedTheme);
            appSetting.them = selectedTheme;
            $.cookie("clip-setting", JSON.stringify(appSetting));
        });
        $('#fixed-sidebar').change(function() {
            $(this).is(":checked") ? app.addClass("app-sidebar-fixed") : app.removeClass("app-sidebar-fixed");
            appSetting.fixedSidebar = $(this).is(":checked");
            $.cookie("clip-setting", JSON.stringify(appSetting));
        });
        $('#fixed-footer').change(function() {
            $(this).is(":checked") ? app.addClass("app-footer-fixed") : app.removeClass("app-footer-fixed");
            appSetting.fixedFooter = $(this).is(":checked");
            $.cookie("clip-setting", JSON.stringify(appSetting));
        });
        function switchLogo(theme) {
            switch (theme) {
                case 'theme-2':
                case 'theme-3':
                case 'theme-4':
                case 'theme-5':
                    $(".navbar-brand img").attr("src", "assets/images/logo2.png");
                    break;
                default: 
                    $(".navbar-brand img").attr("src", "assets/images/logo.png");
                    break;
            }
        }
        function defaultSetting() {
            $('#fixed_header').prop('checked', true);
            $('#fixed_sidebar').prop('checked',  true);
            $('#closed_sidebar').prop('checked', false);
            $('#fixed_footer').prop('checked', false);
            $('#skin_color').attr("href","assets/css/themes/theme1.css");
            $('.nav-brand img').attr("src", "assets/images/logo.png");
        }
    };
    /* Function to allow a button or a link to open a tab */
    var showTabHandler = function(e) {
        if($(".show-tab").length) {
            $(".show-tab").on('click', function(e) {
                e.preventDefault();
                var tabToShow = $(this).attr("href");
                if($(tabToShow).length) {
                    $('a[href=" ' + tabToShow + ' "]').tab('show');
                }
            });
        };
    };
    /* function to enable panel scroll with perfectScrollbar */
    var panelScroll = function() {
        var panelScroll = $(".panel-scroll");
        if(panelScroll.length && !isMobile()) {
            panelScroll.perfectScrollbar({
                supperScrollX: true
            });
        }
    };
    /* Function to active the panel tools */
    var panelTopHandler = function() {

        /* panel close */
        $('body').on('click', '.panel-close', function(e) {
            var panel = $(this).closest('.panel');

            destroyPanel();

            function destroyPanel() {
                var col = panel.parent();
                panel.fadeout(300, function() {
                    $(this).remove();
                    if(col.is('[class*"col-1"]') && col.children('*').length === 0) {
                        col.remove();
                    }
                });
            }
            e.preventDefault();
        });
        /* panel refresh */
        $('body').on('click','.panel-refresh', function(e) {
            var $this = $(this), csspinnerClass = 'csspinner', panel = $this.parents('.panel').eq(0), spinner = $this.data('spinner') || "load1";
            panel.addClass(csspinnerClass + ' ' + spinner);

            window.setTimeout(function() {
                panel.removeClass(csspinnerClass);
            }, 1000);
            e.preventDefault();
        });
        /* Panel collapse */
        $('body').on('click', '.panel-collapse', function(e) {
            e.preventDefault();
            var el = $(this);
            var panel = $(this).closest(".panel");
            var bodPanel = panel.children(".panel-body");
            bodyPanel.slideToggle(200, function() {
                panel.toggleClass("collapses");
            });
        });
    };
    /* Function to activate the Go-Top button */
    var goTopHandler = function(e) {
        $('.go-top').on('click', function(e) {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            e.preventDefault();
        });
    };
    var customSelectHandler = function() {
        [].slice.call(document.querySelectorAll('select.cs-select')).forEach(function(el) {
            new selectFx(el);
        });
    };
    /* Window Resize Function */
    var resizeHandler = function(func, threshold, execAsap) {
        $(window).resize(function() {
            navbarHandler();
            if(isLargeDevice()) {
                $('#app .main-content').css({
                    position: 'relative',
                    top: 'auto',
                    width: 'auto'
                });
                $('footer').show();
            }
        });
    };

    function wrapLeave() {
        wrap.trigger('mouseleave');
    }

    function isTouch() {
        return $html.hasClass('touch');
    }

    function isSmallDevice() {
        return $html.hasClass('touch');
    }

    function isLargeDevice() {
        return $win.width() < MEDDIAQUERY.desktop;
    }

    function isSiderClosed() {
        return $('.app-sidebar-closed').length;
    }

    function isSidebarfixed() {
        return $('.app-sidebar-fixed').length;
    }

    function isMobile() {
        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            return true;
        } else {
            return false;
        }
    }

    return {
        init: function() {
            settingHandler();
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
            panelToolHandler();
            goTopHandler();
        }
    };
}();