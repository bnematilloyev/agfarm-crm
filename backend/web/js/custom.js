/* ----------------- Start Document ----------------- */
(function ($) {
    "use strict";

    $(document).ready(function () {
        /*--------------------------------------------------*/
        /*  Mobile Menu - mmenu.js
        /*--------------------------------------------------*/
        $(function () {
            function mmenuInit() {
                var wi = $(window).width();
                if (wi <= '1099') {

                    $(".mmenu-init").remove();
                    $("#navigation").clone().addClass("mmenu-init").insertBefore("#navigation").removeAttr('id').removeClass('style-1 style-2')
                        .find('ul, div').removeClass('style-1 style-2 mega-menu mega-menu-content mega-menu-section').removeAttr('id');
                    $(".mmenu-init").find("ul").addClass("mm-listview");
                    $(".mmenu-init").find(".mobile-styles .mm-listview").unwrap();


                    $(".mmenu-init").mmenu({
                        "counters": true
                    }, {
                        // configuration
                        offCanvas: {
                            pageNodetype: "#wrapper"
                        }
                    });

                    var mmenuAPI = $(".mmenu-init").data("mmenu");
                    var $icon = $(".mmenu-trigger .hamburger");

                    $(".mmenu-trigger").on('click', function () {
                        mmenuAPI.open();
                    });

                }
                $(".mm-next").addClass("mm-fullsubopen");
            }

            mmenuInit();
            $(window).resize(function () {
                mmenuInit();
            });
        });

        /*--------------------------------------------------*/

        /*  Sticky Header
        /*--------------------------------------------------*/
        function stickyHeader() {

            $(window).on('scroll load', function () {

                if ($(window).width() < '1099') {
                    $("#header-container").removeClass("cloned");
                }

                if ($(window).width() > '1099') {

                    // CSS adjustment
                    $("#header-container").css({
                        position: 'fixed',
                    });

                    var headerOffset = $("#header-container").height();

                    if ($(window).scrollTop() >= headerOffset) {
                        $("#header-container").addClass('cloned');
                        $(".wrapper-with-transparent-header #header-container").addClass('cloned').removeClass("transparent-header unsticky");
                    } else {
                        $("#header-container").removeClass("cloned");
                        $(".wrapper-with-transparent-header #header-container").addClass('transparent-header unsticky').removeClass("cloned");
                    }

                    // Sticky Logo
                    var transparentLogo = $('#header-container #logo img').attr('data-transparent-logo');
                    var stickyLogo = $('#header-container #logo img').attr('data-sticky-logo');

                    if ($('.wrapper-with-transparent-header #header-container').hasClass('cloned')) {
                        $("#header-container.cloned #logo img").attr("src", stickyLogo);
                    }

                    if ($('.wrapper-with-transparent-header #header-container').hasClass('transparent-header')) {
                        $("#header-container #logo img").attr("src", transparentLogo);
                    }

                    $(window).on('load resize', function () {
                        var headerOffset = $("#header-container").height();
                        $("#wrapper").css({'padding-top': headerOffset});
                    });
                }
            });
        }

        // Sticky Header Init
        stickyHeader();


        /*--------------------------------------------------*/
        /*  Transparent Header Spacer Adjustment
        /*--------------------------------------------------*/
        $(window).on('load resize', function () {
            var transparentHeaderHeight = $('.transparent-header').outerHeight();
            $('.transparent-header-spacer').css({
                height: transparentHeaderHeight,
            });
        });


        /*----------------------------------------------------*/
        /*  Back to Top
        /*----------------------------------------------------*/

        // Button
        function backToTop() {
            $('body').append('<div id="backtotop"><a href="#"></a></div>');
        }

        backToTop();

        // Showing Button
        var pxShow = 600; // height on which the button will show
        var scrollSpeed = 500; // how slow / fast you want the button to scroll to top.

        $(window).scroll(function () {
            if ($(window).scrollTop() >= pxShow) {
                $("#backtotop").addClass('visible');
            } else {
                $("#backtotop").removeClass('visible');
            }
        });

        $('#backtotop a').on('click', function () {
            $('html, body').animate({scrollTop: 0}, scrollSpeed);
            return false;
        });


        /*--------------------------------------------------*/
        /*  Ripple Effect
        /*--------------------------------------------------*/
        $('.ripple-effect, .ripple-effect-dark').on('click', function (e) {
            var rippleDiv = $('<span class="ripple-overlay">'),
                rippleOffset = $(this).offset(),
                rippleY = e.pageY - rippleOffset.top,
                rippleX = e.pageX - rippleOffset.left;

            rippleDiv.css({
                top: rippleY - (rippleDiv.height() / 2),
                left: rippleX - (rippleDiv.width() / 2),
                // background: $(this).data("ripple-color");
            }).appendTo($(this));

            window.setTimeout(function () {
                rippleDiv.remove();
            }, 800);
        });


        /*--------------------------------------------------*/
        /*  Interactive Effects
        /*--------------------------------------------------*/
        $(".switch, .radio").each(function () {
            var intElem = $(this);
            intElem.on('click', function () {
                intElem.addClass('interactive-effect');
                setTimeout(function () {
                    intElem.removeClass('interactive-effect');
                }, 400);
            });
        });


        /*--------------------------------------------------*/
        /*  Sliding Button Icon
        /*--------------------------------------------------*/
        $(window).on('load', function () {
            $(".button.button-sliding-icon").not(".task-listing .button.button-sliding-icon").each(function () {
                var buttonWidth = $(this).outerWidth() + 30;
                $(this).css('width', buttonWidth);
            });
        });


        /*--------------------------------------------------*/
        /*  Sliding Button Icon
        /*--------------------------------------------------*/
        $('.bookmark-icon').on('click', function (e) {
            e.preventDefault();
            $(this).toggleClass('bookmarked');
        });

        $('.bookmark-button').on('click', function (e) {
            e.preventDefault();
            $(this).toggleClass('bookmarked');
        });


        /*----------------------------------------------------*/
        /*  Notifications Boxes
        /*----------------------------------------------------*/
        $("a.close").removeAttr("href").on('click', function () {
            function slideFade(elem) {
                var fadeOut = {opacity: 0, transition: 'opacity 0.5s'};
                elem.css(fadeOut).slideUp();
            }

            slideFade($(this).parent());
        });

        /*--------------------------------------------------*/
        /*  Notification Dropdowns
        /*--------------------------------------------------*/
        $(".header-notifications").each(function () {
            var userMenu = $(this);
            var userMenuTrigger = $(this).find('.header-notifications-trigger a');

            $(userMenuTrigger).on('click', function (event) {
                event.preventDefault();

                if ($(this).closest(".header-notifications").is(".active")) {
                    close_user_dropdown();
                } else {
                    close_user_dropdown();
                    userMenu.addClass('active');
                }
            });
        });

        // Closing function
        function close_user_dropdown() {
            $('.header-notifications').removeClass("active");
        }

        // Closes notification dropdown on click outside the conatainer
        var mouse_is_inside = false;

        $(".header-notifications").on("mouseenter", function () {
            mouse_is_inside = true;
        });
        $(".header-notifications").on("mouseleave", function () {
            mouse_is_inside = false;
        });

        $("body").mouseup(function () {
            if (!mouse_is_inside) close_user_dropdown();
        });

        // Close with ESC
        $(document).keyup(function (e) {
            if (e.keyCode == 27) {
                close_user_dropdown();
            }
        });


        /*--------------------------------------------------*/
        /*  User Status Switch
        /*--------------------------------------------------*/
        if ($('.status-switch label.user-invisible').hasClass('current-status')) {
            $('.status-indicator').addClass('right');
        }

        $('.status-switch label.user-invisible').on('click', function () {
            $('.status-indicator').addClass('right');
            $('.status-switch label').removeClass('current-status');
            $('.user-invisible').addClass('current-status');
        });

        $('.status-switch label.user-online').on('click', function () {
            $('.status-indicator').removeClass('right');
            $('.status-switch label').removeClass('current-status');
            $('.user-online').addClass('current-status');
        });


        /*--------------------------------------------------*/
        /*  Full Screen Page Scripts
        /*--------------------------------------------------*/

        // Wrapper Height (window height - header height)
        function wrapperHeight() {
            var headerHeight = $("#header-container").outerHeight();
            var windowHeight = $(window).outerHeight() - headerHeight;
            $('.full-page-content-container, .dashboard-content-container, .dashboard-sidebar-inner, .dashboard-container, .full-page-container').css({height: windowHeight});
            $('.dashboard-content-inner').css({'min-height': windowHeight});
        }

        // Enabling Scrollbar
        function fullPageScrollbar() {
            $(".full-page-sidebar-inner, .dashboard-sidebar-inner").each(function () {

                var headerHeight = $("#header-container").outerHeight();
                var windowHeight = $(window).outerHeight() - headerHeight;
                var sidebarContainerHeight = $(this).find(".sidebar-container, .dashboard-nav-container").outerHeight();

                // Enables scrollbar if sidebar is higher than wrapper
                if (sidebarContainerHeight > windowHeight) {
                    $(this).css({height: windowHeight});

                } else {
                    $(this).find('.simplebar-track').hide();
                }
            });
        }

        // Init
        $(window).on('load resize', function () {
            wrapperHeight();
            fullPageScrollbar();
        });
        wrapperHeight();
        fullPageScrollbar();

        // Sliding Sidebar
        $('.enable-filters-button').on('click', function () {
            $('.full-page-sidebar').toggleClass("enabled-sidebar");
            $(this).toggleClass("active");
            $('.filter-button-tooltip').removeClass('tooltip-visible');
        });

        /*  Enable Filters Button Tooltip */
        $(window).on('load', function () {
            $('.filter-button-tooltip').css({
                left: $('.enable-filters-button').outerWidth() + 48
            })
                .addClass('tooltip-visible');
        });

        // Avatar Switcher
        function avatarSwitcher() {
            var readURL = function (input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.profile-pic').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            };

            $(".file-upload").on('change', function () {
                readURL(this);
            });

            $(".upload-button").on('click', function () {
                $(".file-upload").click();
            });
        }

        avatarSwitcher();


        /*----------------------------------------------------*/
        /* Dashboard Scripts
        /*----------------------------------------------------*/

        // Dashboard Nav Submenus
        $('.dashboard-nav ul li a').on('mouseenter', function (e) {
            if ($(this).closest("li").children("ul").length) {
                if ($(this).closest("li").is(".active-submenu")) {
                    $('.dashboard-nav ul li').removeClass('active-submenu');
                } else {
                    $('.dashboard-nav ul li').removeClass('active-submenu');
                    $(this).parent('li').addClass('active-submenu');
                }
                e.preventDefault();
            }
        });


        // Responsive Dashbaord Nav Trigger
        $('.dashboard-responsive-nav-trigger').on('click', function (e) {
            e.preventDefault();
            $(this).toggleClass('active');

            var dashboardNavContainer = $('body').find(".dashboard-nav");

            if ($(this).hasClass('active')) {
                $(dashboardNavContainer).addClass('active');
            } else {
                $(dashboardNavContainer).removeClass('active');
            }

            $('.dashboard-responsive-nav-trigger .hamburger').toggleClass('is-active');

        });

        // Fun Facts
        function funFacts() {
            /*jslint bitwise: true */
            function hexToRgbA(hex) {
                var c;
                if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
                    c = hex.substring(1).split('');
                    if (c.length == 3) {
                        c = [c[0], c[0], c[1], c[1], c[2], c[2]];
                    }
                    c = '0x' + c.join('');
                    return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ',0.07)';
                }
            }

            $(".fun-fact").each(function () {
                var factColor = $(this).attr('data-fun-fact-color');

                if (factColor !== undefined) {
                    $(this).find(".fun-fact-icon").css('background-color', hexToRgbA(factColor));
                    $(this).find("i").css('color', factColor);
                }
            });

        }

        funFacts();


        // Notes & Messages Scrollbar
        $(window).on('load resize', function () {
            var winwidth = $(window).width();
            if (winwidth > 1199) {

                // Notes
                $('.row').each(function () {
                    var mbh = $(this).find('.main-box-in-row').outerHeight();
                    var cbh = $(this).find('.child-box-in-row').outerHeight();
                    if (mbh < cbh) {
                        var headerBoxHeight = $(this).find('.child-box-in-row .headline').outerHeight();
                        var mainBoxHeight = $(this).find('.main-box-in-row').outerHeight() - headerBoxHeight + 39;

                        $(this).find('.child-box-in-row .content')
                            .wrap('<div class="dashboard-box-scrollbar" style="max-height: ' + mainBoxHeight + 'px" data-simplebar></div>');
                    }
                });

                // Messages Sidebar
                // var messagesList = $(".messages-inbox").outerHeight();
                // var messageWrap = $(".message-content").outerHeight();
                // if ( messagesList > messagesWrap) {
                // 	$(messagesList).css({
                // 		'max-height': messageWrap,
                // 	});
                // }
            }
        });

        // Mobile Adjustment for Single Button Icon in Dashboard Box
        $('.buttons-to-right').each(function () {
            var btr = $(this).width();
            if (btr < 36) {
                $(this).addClass('single-right-button');
            }
        });

        // Small Footer Adjustment
        $(window).on('load resize', function () {
            var smallFooterHeight = $('.small-footer').outerHeight();
            $('.dashboard-footer-spacer').css({
                'padding-top': smallFooterHeight + 45
            });
        });


        // Auto Resizing Message Input Field
        /* global jQuery */
        jQuery.each(jQuery('textarea[data-autoresize]'), function () {
            var offset = this.offsetHeight - this.clientHeight;

            var resizeTextarea = function (el) {
                jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
            };
            jQuery(this).on('keyup input', function () {
                resizeTextarea(this);
            }).removeAttr('data-autoresize');
        });


        /*--------------------------------------------------*/

        /*  Star Rating
        /*--------------------------------------------------*/
        function starRating(ratingElem) {

            $(ratingElem).each(function () {

                var dataRating = $(this).attr('data-rating');

                // Rating Stars Output
                function starsOutput(firstStar, secondStar, thirdStar, fourthStar, fifthStar) {
                    return ('' +
                        '<span class="' + firstStar + '"></span>' +
                        '<span class="' + secondStar + '"></span>' +
                        '<span class="' + thirdStar + '"></span>' +
                        '<span class="' + fourthStar + '"></span>' +
                        '<span class="' + fifthStar + '"></span>');
                }

                var fiveStars = starsOutput('star', 'star', 'star', 'star', 'star');

                var fourHalfStars = starsOutput('star', 'star', 'star', 'star', 'star half');
                var fourStars = starsOutput('star', 'star', 'star', 'star', 'star empty');

                var threeHalfStars = starsOutput('star', 'star', 'star', 'star half', 'star empty');
                var threeStars = starsOutput('star', 'star', 'star', 'star empty', 'star empty');

                var twoHalfStars = starsOutput('star', 'star', 'star half', 'star empty', 'star empty');
                var twoStars = starsOutput('star', 'star', 'star empty', 'star empty', 'star empty');

                var oneHalfStar = starsOutput('star', 'star half', 'star empty', 'star empty', 'star empty');
                var oneStar = starsOutput('star', 'star empty', 'star empty', 'star empty', 'star empty');

                // Rules
                if (dataRating >= 4.75) {
                    $(this).append(fiveStars);
                } else if (dataRating >= 4.25) {
                    $(this).append(fourHalfStars);
                } else if (dataRating >= 3.75) {
                    $(this).append(fourStars);
                } else if (dataRating >= 3.25) {
                    $(this).append(threeHalfStars);
                } else if (dataRating >= 2.75) {
                    $(this).append(threeStars);
                } else if (dataRating >= 2.25) {
                    $(this).append(twoHalfStars);
                } else if (dataRating >= 1.75) {
                    $(this).append(twoStars);
                } else if (dataRating >= 1.25) {
                    $(this).append(oneHalfStar);
                } else if (dataRating < 1.25) {
                    $(this).append(oneStar);
                }

            });

        }

        starRating('.star-rating');


        /*--------------------------------------------------*/

        /*  Enabling Scrollbar in User Menu
        /*--------------------------------------------------*/
        function userMenuScrollbar() {
            $(".header-notifications-scroll").each(function () {
                var scrollContainerList = $(this).find('ul');
                var itemsCount = scrollContainerList.children("li").length;
                var notificationItems;

                // Determines how many items are displayed based on items height
                /* jshint shadow:true */
                if (scrollContainerList.children("li").outerHeight() > 140) {
                    var notificationItems = 2;
                } else {
                    var notificationItems = 3;
                }


                // Enables scrollbar if more than 2 items
                if (itemsCount > notificationItems) {

                    var listHeight = 0;

                    $(scrollContainerList).find('li:lt(' + notificationItems + ')').each(function () {
                        listHeight += $(this).height();
                    });

                    $(this).css({height: listHeight});

                } else {
                    $(this).css({height: 'auto'});
                    $(this).find('.simplebar-track').hide();
                }
            });
        }

        // Init
        userMenuScrollbar();

        /*----------------------------------------------------*/
        /*	Accordion @Lewis Briffa
        /*----------------------------------------------------*/
        var accordion = (function () {

            var $accordion = $('.js-accordion');
            var $accordion_header = $accordion.find('.js-accordion-header');

            // default settings
            var settings = {
                // animation speed
                speed: 400,

                // close all other accordion items if true
                oneOpen: false
            };

            return {
                // pass configurable object literal
                init: function ($settings) {
                    $accordion_header.on('click', function () {
                        accordion.toggle($(this));
                    });

                    $.extend(settings, $settings);

                    // ensure only one accordion is active if oneOpen is true
                    if (settings.oneOpen && $('.js-accordion-item.active').length > 1) {
                        $('.js-accordion-item.active:not(:first)').removeClass('active');
                    }

                    // reveal the active accordion bodies
                    $('.js-accordion-item.active').find('> .js-accordion-body').show();
                },
                toggle: function ($this) {

                    if (settings.oneOpen && $this[0] != $this.closest('.js-accordion').find('> .js-accordion-item.active > .js-accordion-header')[0]) {
                        $this.closest('.js-accordion')
                            .find('> .js-accordion-item')
                            .removeClass('active')
                            .find('.js-accordion-body')
                            .slideUp();
                    }

                    // show/hide the clicked accordion item
                    $this.closest('.js-accordion-item').toggleClass('active');
                    $this.next().stop().slideToggle(settings.speed);
                }
            };
        })();

        $(document).ready(function () {
            accordion.init({speed: 300, oneOpen: true});
        });

        /*--------------------------------------------------*/
        /*  Tabs
        /*--------------------------------------------------*/
        $('.tabs > .tabs-header > ul > li > .tab__link').on('click', function () {
            var thisElement = $(this);

            $(".tabs .tabs-content .tab").removeClass('active');
            $(".tabs .tabs-content .tab[data-tab-id='" + thisElement.attr('data-tab-id') + "']").addClass("active");
            $(".tabs > .tabs-header > ul > li > .tab__link").removeClass('active');
            thisElement.parent().find(".tab__link").addClass('active');

        });

        /*--------------------------------------------------*/
        /*  Keywords
        /*--------------------------------------------------*/
        $(".keywords-container").each(function () {

            var keywordInput = $(this).find(".keyword-input");
            var keywordsList = $(this).find(".keywords-list");

            // adding keyword
            function addKeyword() {
                var $newKeyword = $("<span class='keyword'><span class='keyword-remove'></span><span class='keyword-text'>" + keywordInput.val() + "</span></span>");
                keywordsList.append($newKeyword).trigger('resizeContainer');
                keywordInput.val("");
            }

            // add via enter key
            keywordInput.on('keyup', function (e) {
                if ((e.keyCode == 13) && (keywordInput.val() !== "")) {
                    addKeyword();
                }
            });

            // add via button
            $('.keyword-input-button').on('click', function () {
                if ((keywordInput.val() !== "")) {
                    addKeyword();
                }
            });

            // removing keyword
            $(document).on("click", ".keyword-remove", function () {
                $(this).parent().addClass('keyword-removed');

                function removeFromMarkup() {
                    $(".keyword-removed").remove();
                }

                setTimeout(removeFromMarkup, 500);
                keywordsList.css({'height': 'auto'}).height();
            });


            // animating container height
            keywordsList.on('resizeContainer', function () {
                var heightnow = $(this).height();
                var heightfull = $(this).css({'max-height': 'auto', 'height': 'auto'}).height();

                $(this).css({'height': heightnow}).animate({'height': heightfull}, 200);
            });

            $(window).on('resize', function () {
                keywordsList.css({'height': 'auto'}).height();
            });

            // Auto Height for keywords that are pre-added
            $(window).on('load', function () {
                var keywordCount = $('.keywords-list').children("span").length;

                // Enables scrollbar if more than 3 items
                if (keywordCount > 0) {
                    keywordsList.css({'height': 'auto'}).height();

                }
            });

        });


        /*--------------------------------------------------*/
        /*  Bootstrap Range Slider
        /*--------------------------------------------------*/

        // Thousand Separator
        function ThousandSeparator(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        // Bidding Slider Average Value
        var avgValue = (parseInt($('.bidding-slider').attr("data-slider-min")) + parseInt($('.bidding-slider').attr("data-slider-max"))) / 2;
        if ($('.bidding-slider').data("slider-value") === 'auto') {
            $('.bidding-slider').attr({'data-slider-value': avgValue});
        }

        // Bidding Slider Init
        $('.bidding-slider').slider();

        $(".bidding-slider").on("slide", function (slideEvt) {
            $("#biddingVal").text(ThousandSeparator(parseInt(slideEvt.value)));
        });
        $("#biddingVal").text(ThousandSeparator(parseInt($('.bidding-slider').val())));


        // Default Bootstrap Range Slider
        var currencyAttr = $(".range-slider").attr('data-slider-currency');

        $(".range-slider").slider({
            formatter: function (value) {
                return currencyAttr + ThousandSeparator(parseInt(value[0])) + " - " + currencyAttr + ThousandSeparator(parseInt(value[1]));
            }
        });

        $(".range-slider-single").slider();


        /*----------------------------------------------------*/
        /*  Payment Accordion
        /*----------------------------------------------------*/
        var radios = document.querySelectorAll('.payment-tab-trigger > input');

        for (var i = 0; i < radios.length; i++) {
            radios[i].addEventListener('change', expandAccordion);
        }

        function expandAccordion(event) {
            /* jshint validthis: true */
            var tabber = this.closest('.payment');
            var allTabs = tabber.querySelectorAll('.payment-tab');
            for (var i = 0; i < allTabs.length; i++) {
                allTabs[i].classList.remove('payment-tab-active');
            }
            event.target.parentNode.parentNode.classList.add('payment-tab-active');
        }

        $('.billing-cycle-radios').on("click", function () {
            if ($('.billed-yearly-radio input').is(':checked')) {
                $('.pricing-plans-container').addClass('billed-yearly');
            }
            if ($('.billed-monthly-radio input').is(':checked')) {
                $('.pricing-plans-container').removeClass('billed-yearly');
            }
        });


        /*--------------------------------------------------*/

        /*  Quantity Buttons
        /*--------------------------------------------------*/
        function qtySum() {
            var arr = document.getElementsByName('qtyInput');
            var tot = 0;
            for (var i = 0; i < arr.length; i++) {
                if (parseInt(arr[i].value))
                    tot += parseInt(arr[i].value);
            }
        }

        qtySum();

        $(".qtyDec, .qtyInc").on("click", function () {

            var $button = $(this);
            var oldValue = $button.parent().find("input").val();

            if ($button.hasClass('qtyInc')) {
                $button.parent().find("input").val(parseFloat(oldValue) + 1);
            } else {
                if (oldValue > 1) {
                    $button.parent().find("input").val(parseFloat(oldValue) - 1);
                } else {
                    $button.parent().find("input").val(1);
                }
            }

            qtySum();
            $(".qtyTotal").addClass("rotate-x");

        });


        /*----------------------------------------------------*/

        /*  Inline CSS replacement for backgrounds
        /*----------------------------------------------------*/
        function inlineBG() {

            // Common Inline CSS
            $(".single-page-header, .intro-banner").each(function () {
                var attrImageBG = $(this).attr('data-background-image');

                if (attrImageBG !== undefined) {
                    $(this).append('<div class="background-image-container"></div>');
                    $('.background-image-container').css('background-image', 'url(' + attrImageBG + ')');
                }
            });

        }

        inlineBG();

        // Fix for intro banner with label
        $(".intro-search-field").each(function () {
            var bannerLabel = $(this).children("label").length;
            if (bannerLabel > 0) {
                $(this).addClass("with-label");
            }
        });

        // Photo Boxes
        $(".photo-box, .photo-section, .video-container").each(function () {
            var photoBox = $(this);
            var photoBoxBG = $(this).attr('data-background-image');

            if (photoBox !== undefined) {
                $(this).css('background-image', 'url(' + photoBoxBG + ')');
            }
        });


        /*----------------------------------------------------*/
        /*  Tabs
        /*----------------------------------------------------*/
        var $tabsNav = $('.popup-tabs-nav'),
            $tabsNavLis = $tabsNav.children('li');

        $tabsNav.each(function () {
            var $this = $(this);

            $this.next().children('.popup-tab-content').stop(true, true).hide().first().show();
            $this.children('li').first().addClass('active').stop(true, true).show();
        });

        $tabsNavLis.on('click', function (e) {
            var $this = $(this);

            $this.siblings().removeClass('active').end().addClass('active');

            $this.parent().next().children('.popup-tab-content').stop(true, true).hide()
                .siblings($this.find('a').attr('href')).fadeIn();

            e.preventDefault();
        });

        var hash = window.location.hash;
        var anchor = $('.tabs-nav a[href="' + hash + '"]');
        if (anchor.length === 0) {
            $(".popup-tabs-nav li:first").addClass("active").show(); //Activate first tab
            $(".popup-tab-content:first").show(); //Show first tab content
        } else {
            anchor.parent('li').click();
        }

        // Link to Register Tab
        $('.register-tab').on('click', function (event) {
            event.preventDefault();
            $(".popup-tab-content").hide();
            $("#register.popup-tab-content").show();
            $("body").find('.popup-tabs-nav a[href="#register"]').parent("li").click();
        });

        // Disable tabs if there's only one tab
        $('.popup-tabs-nav').each(function () {
            var listCount = $(this).find("li").length;
            if (listCount < 2) {
                $(this).css({
                    'pointer-events': 'none'
                });
            }
        });


        /*----------------------------------------------------*/
        /*  Indicator Bar
        /*----------------------------------------------------*/
        $('.indicator-bar').each(function () {
            var indicatorLenght = $(this).attr('data-indicator-percentage');
            $(this).find("span").css({
                width: indicatorLenght + "%"
            });
        });


        /*----------------------------------------------------*/
        /*  Custom Upload Button
        /*----------------------------------------------------*/

        var uploadButton = {
            $button: $('.uploadButton-input'),
            $nameField: $('.uploadButton-file-name')
        };

        uploadButton.$button.on('change', function () {
            _populateFileField($(this));
        });

        function _populateFileField($button) {
            var selectedFile = [];
            for (var i = 0; i < $button.get(0).files.length; ++i) {
                selectedFile.push($button.get(0).files[i].name + '<br>');
            }
            uploadButton.$nameField.html(selectedFile);
        }

        /*----------------------------------------------------*/
        /*  SHOW PASSWORD
        /*----------------------------------------------------*/
        var btnShowPass = $('.btn-show-pass');
        var showPass = 0;

        btnShowPass.on('click', function () {
            if (showPass == 0) {
                $(this).next('input').attr('type', 'text');
                $(this).text('🙉');
                $(this).text('🙈');
                showPass = 1;
            } else {
                $(this).next('input').attr('type', 'password');
                $(this).text('🙈');
                $(this).text('🙉');
                showPass = 0;
            }
        });
// ------------------ End Document ------------------ //
    });

})(this.jQuery);

function call_pnotify(status, text, time = 3000) {
    switch (status) {
        case 'success':
            PNotify.defaults.styling = "bootstrap4";
            PNotify.defaults.delay = time;
            PNotify.alert({text: text, type: 'success'});
            // PNotify.success({title:text,text:text});
            break;
        case 'fail':
            PNotify.defaults.styling = "bootstrap4";
            PNotify.defaults.delay = time;
            PNotify.alert({text: text, type: 'error'});
            break;
        case 'info':
            PNotify.defaults.styling = "bootstrap4";
            PNotify.defaults.delay = time;
            PNotify.alert({text: text, type: 'info'});
            break;
        case 'notice':
            PNotify.defaults.styling = "bootstrap4";
            PNotify.defaults.delay = time;
            PNotify.alert({text: text, type: 'notice'});
            break;
    }
};
$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});
$(document).on('keyup', function (e) {
    if (e.key === "Escape" || e.keyCode === 27) {
        if ($('body').hasClass('modal-open') || $('body').hasClass('fancybox-active')) {
            console.log('it is working');
        } else if (window.location.href.indexOf("create") > -1 || window.location.href.indexOf("update") > -1){
            let r = confirm('Rostdan ham chiqib ketmoqchimisiz??');
            if (r === true)
                window.history.back();
        }else {
            window.history.back();
        }
    }
});

let theme = localStorage.getItem('data-theme');
var style = document.getElementById("style-switch");

var changeThemeToDark = () => {
    document.documentElement.setAttribute("data-theme", "dark")
    style.setAttribute('href', '/css/darkmode.css?ver=3');
    localStorage.setItem("data-theme", "dark")
}

var changeThemeToLight = () => {
    document.documentElement.setAttribute("data-theme", "light")
    style.setAttribute('href', '');
    localStorage.setItem("data-theme", 'light')
}

if (theme === 'dark') {
    changeThemeToDark()
} else if (theme == null || theme === 'light') {
    changeThemeToLight();
}


$('#darkModeSwitch').click(() => {
    let theme = localStorage.getItem('data-theme'); // Retrieve saved them from local storage
    if (theme === 'dark') {
        changeThemeToLight()
    } else {
        changeThemeToDark()
    }
});
function customNavigate(step) {
    window.history.back();
}

document.addEventListener('DOMContentLoaded', function () {
    let emptyContainer = document.createElement('div');
    emptyContainer.classList.add('d-flex', 'justify-content-center', 'align-items-center', 'flex-column');
    emptyContainer.style.height = '200px';
    emptyContainer.style.gap = '15px';

    let imgElement = document.createElement('img');
    imgElement.src = '/images/icons/Folder.svg';
    emptyContainer.appendChild(imgElement);

    let textElement = document.createTextNode('Hech nima topilmadi.');
    emptyContainer.appendChild(textElement);

    let emptyElements = document.querySelectorAll('.empty');

    emptyElements.forEach(function (emptyElement) {
        emptyElement.innerHTML = '';
        emptyElement.appendChild(emptyContainer.cloneNode(true));
    });
});