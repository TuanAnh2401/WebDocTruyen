/*  ---------------------------------------------------
    Theme Name: Anime
    Description: Anime video tamplate
    Author: Colorib
    Author URI: https://colorib.com/
    Version: 1.0
    Created: Colorib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            FIlter
        --------------------*/
        $('.filter__controls li').on('click', function () {
            $('.filter__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.filter__gallery').length > 0) {
            var containerEl = document.querySelector('.filter__gallery');
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    // Search model
    $('.search-switch').on('click', function () {
        $('.search-model').fadeIn(400);
    });

    $('.search-close-switch').on('click', function () {
        $('.search-model').fadeOut(400, function () {
            $('#search-input').val('');
        });
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
		Hero Slider
	--------------------*/
    var hero_s = $(".hero__slider");
    hero_s.owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: true,
        nav: true,
        navText: ["<span class='arrow_carrot-left'></span>", "<span class='arrow_carrot-right'></span>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        mouseDrag: false
    });

    /*------------------
        Video Player
    --------------------*/
    const player = new Plyr('#player', {
        controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'captions', 'settings', 'fullscreen'],
        seekTime: 25
    });

    /*------------------
        Niceselect
    --------------------*/
    $('select').niceSelect();

    /*------------------
        Scroll To Top
    --------------------*/
    $("#scrollToTopButton").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
     });

})(jQuery);
// Lắng nghe sự kiện click trên toàn bộ tài liệu (document)
document.addEventListener("click", function(event) {
    var profileIcon = document.getElementById("profileIcon");
    var dropdownMenu = document.getElementById("profileDropdown");

    // Kiểm tra xem phần tử được nhấp có thuộc menu dropdown hay không
    var isClickInsideDropdown = dropdownMenu.contains(event.target) || profileIcon.contains(event.target);

    // Nếu không, ẩn menu dropdown
    if (!isClickInsideDropdown) {
        dropdownMenu.classList.remove("active");
    }
});

// Lắng nghe sự kiện click vào icon thông tin tài khoản
document.getElementById("profileIcon").addEventListener("click", function(event) {
    event.stopPropagation(); // Ngăn chặn sự kiện click từ việc lan truyền ra ngoài

    var dropdownMenu = document.getElementById("profileDropdown");

    // Kiểm tra xem dropdown-menu có hiển thị hay không
    var isShown = dropdownMenu.classList.contains("active");

    // Nếu đang hiển thị, ẩn đi; nếu đang ẩn, hiển thị lên
    if (isShown) {
        dropdownMenu.classList.remove("active");
    } else {
        dropdownMenu.classList.add("active");
    }
});

