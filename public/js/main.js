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
      function toggleIsDelete(movieId, isDelete) {
        // Gửi yêu cầu Ajax với phương thức POST
        $.ajax({
            url: '{{ route("toggle.is.delete", ["id" => ":id"]) }}'.replace(':id', movieId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                // Chuyển đổi trạng thái IsDelete để gửi
                isDelete: isDelete ? 0 : 1 // Nếu isDelete là true, gửi 0; nếu không, gửi 1
            },
            success: function(response) {
                // Nếu thành công, làm mới trang
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

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
    vipForm.classList.toggle('active');
    document.getElementById('vipForm').style.display = 'block';
});

document.getElementById('vipForm').querySelector('.close-button').addEventListener('click', function() {
    document.getElementById('vipForm').style.display = 'none';
});


document.addEventListener('DOMContentLoaded', function() {
    var priceButtons = document.querySelectorAll('.price-button');
    var priceDetailContent = document.getElementById('priceDetailContent');
    var priceDetail = document.getElementById('priceDetail');
    var priceIdInput = document.getElementById('price_id');

    priceButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var detail = this.getAttribute('data-detail');
            var priceId = this.getAttribute('data-price-id');

            priceDetailContent.innerText = detail;
            priceDetail.style.display = 'block';

            priceIdInput.value = priceId;

            priceButtons.forEach(function(btn) {
                btn.classList.remove('selected');
            });
            
            this.classList.add('selected');
        });
    });
});
function formatPrice(price) {
    var number = parseFloat(price);
    var formattedPrice = number.toFixed(0);
    formattedPrice = formattedPrice.replace(/\B(?=(\d{3})+(?!\d))/g, ".")+"đ";
    return formattedPrice;
}

var priceInfoElements = document.querySelectorAll('.price-info');
priceInfoElements.forEach(function(element) {
    var originalPriceElement = element.querySelector('.original-price');
    if (originalPriceElement) {
        var originalPrice = originalPriceElement.textContent;
        originalPriceElement.textContent = formatPrice(originalPrice);
    }

    var salePriceElement = element.querySelector('.sale-price');
    if (salePriceElement) {
        var salePrice = salePriceElement.textContent;
        salePriceElement.textContent = formatPrice(salePrice);
    }
});
document.addEventListener('DOMContentLoaded', function() {
    var avatarInput = document.getElementById('avatar-input');
    if (avatarInput) {
        avatarInput.addEventListener('change', function(event) {
            var preview = document.getElementById('avatar-preview');
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    var paymentForm = document.getElementById('paymentForm');

    if (paymentForm) {
        paymentForm.addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(paymentForm);

            fetch(paymentForm.action, {
                method: paymentForm.method,
                body: formData
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.error) {
                    alert(data.error);
                } else if (data.warning) {
                    alert(data.warning);
                } else if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    console.error('Response không chứa thông tin cần thiết.');
                }
            })
            .catch(function(error) {
                console.error('Đã xảy ra lỗi:', error);
            });
        });
    }
});





