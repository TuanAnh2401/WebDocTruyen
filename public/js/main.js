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

document.addEventListener("click", function(event) {
    var profileIcon = document.getElementById("profileIcon");
    var dropdownMenu = document.getElementById("profileDropdown");

    var isClickInsideDropdown = dropdownMenu.contains(event.target) || profileIcon.contains(event.target);

    if (!isClickInsideDropdown) {
        dropdownMenu.classList.remove("active");
    }
});

document.getElementById("profileIcon").addEventListener("click", function(event) {
    event.stopPropagation();

    var dropdownMenu = document.getElementById("profileDropdown");

    var isShown = dropdownMenu.classList.contains("active");

    if (isShown) {
        dropdownMenu.classList.remove("active");
    } else {
        dropdownMenu.classList.add("active");
    }
});

document.getElementById('vipMenu').addEventListener('click', function(event) {
    event.preventDefault(); 
    document.getElementById('vipForm').style.display = 'block';
});

document.querySelector('.close-button').addEventListener('click', function() {
    document.getElementById('vipForm').style.display = 'none';
});

document.addEventListener('DOMContentLoaded', function() {
    var priceButtons = document.querySelectorAll('.price-button');
    var priceDetailContent = document.getElementById('priceDetailContent');
    var priceDetail = document.getElementById('priceDetail');
    var paymentForm = document.getElementById('paymentForm');
    var amountInput = document.getElementById('amount');

    priceButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var detail = this.getAttribute('data-detail');
            var priceSale = parseFloat(this.getAttribute('data-price-sale'));
            var price = parseFloat(this.getAttribute('data-price'));

            if (priceSale) {
                amountInput.value = priceSale.toFixed(2);
            } else {
                amountInput.value = price.toFixed(2); 
            }

            priceDetailContent.innerText = detail;
            priceDetail.style.display = 'block';
            priceButtons.forEach(function(btn) {
                btn.classList.remove('selected');
            });
            this.classList.add('selected');
        });
    });
});






