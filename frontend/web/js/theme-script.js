/* ------------------------------------------------
  Project:   Asaxiy workify
  Author:    Murad developer
  ------------------------------------------------ */

"use strict";

/*------------------------------------
  HT Predefined Variables
--------------------------------------*/
var $window = $(window),
    $document = $(document),
    $body = $('body'),
    $fullScreen = $('.fullscreen-banner') || $('.section-fullscreen'),
    $halfScreen = $('.halfscreen-banner'),
    searchActive = false;

//Check if function exists
$.fn.exists = function () {
    return this.length > 0;
};


/*------------------------------------
  HT PreLoader
--------------------------------------*/
function preloader() {
    $('#ht-preloader').fadeOut();
};


/*------------------------------------
  HT Menu
--------------------------------------*/
function menu() {
    $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');

        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
            $('.dropdown-submenu .show').removeClass("show");
        });

        return false;
    });
};


/*------------------------------------
  HT FullScreen
--------------------------------------*/
function fullScreen() {
    if ($fullScreen.exists()) {
        $fullScreen.each(function () {
            var $elem = $(this),
                elemHeight = $window.height();
            if ($window.width() < 768) $elem.css('height', elemHeight / 1);
            else $elem.css('height', elemHeight);
        });
    }
    if ($halfScreen.exists()) {
        $halfScreen.each(function () {
            var $elem = $(this),
                elemHeight = $window.height();
            $elem.css('height', elemHeight / 2);
        });
    }
};


/*------------------------------------
  HT Counter
--------------------------------------*/
function counter() {
    $('.count-number').countTo({
        refreshInterval: 2
    });
};


/*------------------------------------
  HT Owl Carousel
--------------------------------------*/
function owlcarousel() {
    $('.owl-carousel').each(function () {
        var $carousel = $(this);
        $carousel.owlCarousel({
            items: $carousel.data("items"),
            slideBy: $carousel.data("slideby"),
            center: $carousel.data("center"),
            loop: true,
            margin: $carousel.data("margin"),
            dots: $carousel.data("dots"),
            nav: $carousel.data("nav"),
            autoplay: $carousel.data("autoplay"),
            autoplayTimeout: $carousel.data("autoplay-timeout"),
            autoplaySpeed: 1000,
            navText: ['<span class="fas fa-long-arrow-alt-left"><span>', '<span class="fas fa-long-arrow-alt-right"></span>'],
            responsive: {
                0: {items: $carousel.data('xs-items') ? $carousel.data('xs-items') : 1},
                576: {items: $carousel.data('sm-items')},
                768: {items: $carousel.data('md-items')},
                1024: {items: $carousel.data('lg-items')},
                1200: {items: $carousel.data("items")}
            },
        });
    });
};


/*------------------------------------
  HT Magnific Popup
--------------------------------------*/
function magnificpopup() {
    $('.popup-gallery').magnificPopup({
        delegate: 'a.popup-img',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            titleSrc: function (item) {
                return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
            }
        }
    });
    if ($(".popup-youtube, .popup-vimeo, .popup-gmaps").exists()) {
        $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
    }

};


/*------------------------------------
  HT Isotope
--------------------------------------*/
function isotope() {
    // init Isotope
    var $grid = $('.grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows',
    });

    // filter functions
    var filterFns = {
        // show if number is greater than 50
        numberGreaterThan50: function () {
            var number = $(this).find('.number').text();
            return parseInt(number, 10) > 50;
        },
        // show if name ends with -ium
        ium: function () {
            var name = $(this).find('.name').text();
            return name.match(/ium$/);
        }
    };

    // bind filter button click
    $('.portfolio-filter').on('click', 'button', function () {
        var filterValue = $(this).attr('data-filter');
        // use filterFn if matches value
        filterValue = filterFns[filterValue] || filterValue;
        $grid.isotope({filter: filterValue});
    });


    // change is-checked class on buttons
    $('.portfolio-filter').each(function (i, buttonGroup) {
        var $buttonGroup = $(buttonGroup);
        $buttonGroup.on('click', 'button', function () {
            $buttonGroup.find('.is-checked').removeClass('is-checked');
            $(this).addClass('is-checked');
        });
    });
};


/*------------------------------------
  HT Scroll to top
--------------------------------------*/
function scrolltop() {
    var pxShow = 300,
        goTopButton = $(".scroll-top")
    // Show or hide the button
    if ($(window).scrollTop() >= pxShow) goTopButton.addClass('scroll-visible');
    $(window).on('scroll', function () {
        if ($(window).scrollTop() >= pxShow) {
            if (!goTopButton.hasClass('scroll-visible')) goTopButton.addClass('scroll-visible')
        } else {
            goTopButton.removeClass('scroll-visible')
        }
    });
    $('.smoothscroll').on('click', function (e) {
        $('body,html').animate({
            scrollTop: 0
        }, 1000);
        return false;
    });
};


/*------------------------------------
 HT Banner Section
--------------------------------------*/
function headerheight() {
    $('.fullscreen-banner .align-center').each(function () {
        var headerHeight = $('.header').height();
        // headerHeight+=15; // maybe add an offset too?
        $(this).css('padding-top', headerHeight + 'px');
    });
};


/*------------------------------------
  HT Fixed Header
--------------------------------------*/
function fxheader() {
    $(window).on('scroll', function () {
        if ($(window).scrollTop() >= 100) {
            $('#header-wrap').addClass('fixed-header');
        } else {
            $('#header-wrap').removeClass('fixed-header');
        }
    });
};

/*------------------------------------
  HT Side Menu
--------------------------------------*/
function sidenav() {
    $('.ht-nav-toggle').on('click', function (event) {
        event.preventDefault();
        var $this = $(this);
        if ($('body').hasClass('menu-show')) {
            $('body').removeClass('menu-show');
            $('#ht-main-nav > .ht-nav-toggle').removeClass('show');
        } else {
            $('body').addClass('menu-show');
            setTimeout(function () {
                $('#ht-main-nav > .ht-nav-toggle').addClass('show');
            }, 900);
        }
    })
};

/*------------------------------------------
  HT Text Color, Background Color And Image
---------------------------------------------*/
function databgcolor() {
    $('[data-bg-color]').each(function (index, el) {
        $(el).css('background-color', $(el).data('bg-color'));
    });
    $('[data-text-color]').each(function (index, el) {
        $(el).css('color', $(el).data('text-color'));
    });
    $('[data-bg-img]').each(function () {
        $(this).css('background-image', 'url(' + $(this).data("bg-img") + ')');
    });
};


/*------------------------------------
  HT Contact Form
--------------------------------------*/
function contactform() {
    // when the form is submitted
    $('#contact-form').on('submit', function (e) {

        // if the validator does not prevent form submit
        if (!e.isDefaultPrevented()) {
            var url = "php/contact.php";

            // POST values in the background the the script URL
            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function (data) {
                    // data = JSON object that contact.php returns

                    // we recieve the type of the message: success x danger and apply it to the
                    var messageAlert = 'alert-' + data.type;
                    var messageText = data.message;

                    // let's compose Bootstrap alert box HTML
                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';

                    // If we have messageAlert and messageText
                    if (messageAlert && messageText) {
                        // inject the alert to .messages div in our form
                        $('#contact-form').find('.messages').html(alertBox).show().delay(2000).fadeOut('slow');
                        // empty the form
                        $('#contact-form')[0].reset();
                    }
                }
            });
            return false;
        }
    })
};


/*------------------------------------
  HT Masonry
--------------------------------------*/
function masonry() {
    var $masonry = $('.masonry'),
        $itemElement = '.masonry-brick',
        $filters = $('.portfolio-filter');
    if ($masonry.exists()) {
        $masonry.isotope({
            resizable: true,
            itemSelector: $itemElement,
        });

        // bind filter button click
        $filters.on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            $masonry.isotope({filter: filterValue});
        });
    }
};


/*------------------------------------
  HT Search
--------------------------------------*/
function search() {
    if ($('.search-form').length) {
        var searchForm = $('.search-form');
        var searchInput = $('.search-input');
        var searchButton = $('.search-button');

        searchButton.on('click', function (event) {
            event.stopPropagation();

            if (!searchActive) {
                searchForm.addClass('active');
                searchActive = true;
                searchInput.focus();

                $(document).one('click', function closeForm(e) {
                    if ($(e.target).hasClass('search-input')) {
                        $(document).one('click', closeForm);
                    } else {
                        searchForm.removeClass('active');
                        searchActive = false;
                    }
                });
            } else {
                searchForm.removeClass('active');
                searchActive = false;
            }
        });
    }
};


/*------------------------------------
  HT Countdown
--------------------------------------*/
function countdown() {
    $('.countdown').each(function () {
        var $this = $(this),
            finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function (event) {
            $(this).html(event.strftime('<li><span>%-D</span><p>Days</p></li>' + '<li><span>%-H</span><p>Hours</p></li>' + '<li><span>%-M</span><p>Minutes</p></li>' + '<li><span>%S</span><p>Seconds</p></li>'));
        });
    });
};


/*------------------------------------
  HT Mouse Parallax
--------------------------------------*/
function mouse() {
    $(document).mousemove(function (e) {
        $('.mouse-parallax').parallax(-30, e);
    });
};


/*------------------------------------
  HT insideText
--------------------------------------*/
function insideText() {
    var e, i = $(window).height(),
        n = i / 2;
    $(document).scroll(function () {
        e = $(window).scrollTop(), $(".insideText").each(function () {
            var i = $(this),
                o = i.parent("section"),
                s = o.offset().top;
            i.css({
                top: -(s - e) + n + "px"
            })
        }), $(".bg-text").each(function () {
            var e = $(this),
                i = $(window).height() / 2,
                n = e.parent("div"),
                o = $(window).scrollTop(),
                s = n.offset().top;
            $(this).css({
                top: -(s - o) + i + "px"
            })
        })
    })
};

/*------------------------------------
  HT Wow Animation
--------------------------------------*/
function wowanimation() {
    var wow = new WOW({
        boxClass: 'wow',
        animateClass: 'animated',
        offset: 0,
        mobile: true,
        live: true
    });
    wow.init();
}


/*------------------------------------
  HT Window load and functions
--------------------------------------*/
$(document).ready(function () {
    owlcarousel(),
        menu(),
        fullScreen(),
        counter(),
        magnificpopup(),
        scrolltop(),
        headerheight(),
        fxheader(),
        sidenav(),
        databgcolor(),
        contactform(),
        search(),
        countdown(),
        mouse(),
        insideText();
});


$window.resize(function () {
});


$(window).on('load', function () {
    preloader(),
        isotope(),
        masonry(),
        wowanimation();
});


function toScroll(element) {
    let defaultAnchorOffset = 0;
    let anchor = $(element).attr('data-href');

    let anchorOffset = $('.' + anchor).attr('data-anchor-offset');
    if (!anchorOffset)
        anchorOffset = defaultAnchorOffset;

    $('html,body').animate({
        scrollTop: $('.' + anchor).offset().top - anchorOffset
    }, 800);
}

ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map("map", {
            center: [41.311151, 69.279737],
            zoom: 5
        }, {
            searchControlProvider: 'yandex#search'
        }),


        novza = new ymaps.Placemark([41.293978, 69.221391], {
            balloonContent: '<strong>Novza filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        abu_sahiy = new ymaps.Placemark([41.244871, 69.168710], {
            balloonContent: '<strong>Abu Saxiy filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        abu_sahiy2 = new ymaps.Placemark([41.245768, 69.167075], {
            balloonContent: '<strong>Abu Saxiy filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        abu_sahiy3 = new ymaps.Placemark([41.246431, 69.167825], {
            balloonContent: '<strong>Abu Saxiy filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        malika = new ymaps.Placemark([41.339118, 69.270587], {
            balloonContent: '<strong>Malika filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        malika2 = new ymaps.Placemark([41.337935, 69.271540], {
            balloonContent: '<strong>Malika filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        chilanzar = new ymaps.Placemark([41.310993, 69.249362], {
            balloonContent: '<strong>Chilonzor filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        karshi = new ymaps.Placemark([38.841640, 65.789979], {
            balloonContent: '<strong>Qarshi filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        shakhrisabz = new ymaps.Placemark([39.060073, 66.8294839], {
            balloonContent: '<strong>Shahrisabz filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        kogon = new ymaps.Placemark([39.753143, 64.582132], {
            balloonContent: '<strong>Shahrisabz filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        zarafshan = new ymaps.Placemark([41.568824, 64.2026652], {
            balloonContent: '<strong>Zarafshon filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        jizzakh = new ymaps.Placemark([40.120288, 67.828508], {
            balloonContent: '<strong>Jizzax filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        navoiy = new ymaps.Placemark([40.103093, 65.3739702], {
            balloonContent: '<strong>Navoiy filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        gijduvan = new ymaps.Placemark([40.102797, 64.678476], {
            balloonContent: '<strong>G\'ijduvon filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        buxara = new ymaps.Placemark([39.767966, 64.421728], {
            balloonContent: '<strong>Buxoro filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        }),

        karavulbazar = new ymaps.Placemark([39.398799, 64.772431], {
            balloonContent: '<strong>Qorovulbozor filiali</strong>'
        }, {
            preset: 'islands#blueShoppingIcon',
            iconColor: '#008dff'
        });


    myMap.geoObjects
        .add(malika)
        .add(malika2)
        .add(novza)
        .add(abu_sahiy)
        .add(abu_sahiy2)
        .add(abu_sahiy3)
        .add(chilanzar)
        .add(karshi)
        .add(shakhrisabz)
        .add(kogon)
        .add(zarafshan)
        .add(navoiy)
        .add(gijduvan)
        .add(buxara)
        .add(jizzakh)
        .add(karavulbazar)
        .add(navoiy)
}