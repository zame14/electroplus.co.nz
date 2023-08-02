jQuery(function($) {
    if($(".gallery-section").length == 1) {
        var $container = $(".grid");
        $container.imagesLoaded(function () {
            $container.masonry({
                itemSelector: '.grid-item'
            });
        });
    }
    setTimeout(function () {
        $(".home-banner-wrapper").addClass('ani-show');
    }, 200);
    setTimeout(function () {
        $("#ep-menu-wrapper").addClass('ani-show');
        $("#header .logo").addClass('ani-show');
        $(".banner-content-wrapper").addClass('ani-show');
        $(".page-title").addClass('ani-show');
        $(".gallery-section").addClass('ani-show');
    }, 500);
    if($(".image-slider").length == 1) {
        imageSlick = $(".image-slider").slick({
            dots: false,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            nextArrow: '<i class="fa fa-angle-right"></i>',
            prevArrow: '<i class="fa fa-angle-left"></i>',
            infinite: true
        });
    }
    if($(".testimonial-slider").length == 1) {
        tSlick = $(".testimonial-slider").slick({
            dots: false,
            slidesToShow: 1,
            arrows: true,
            nextArrow: '<i class="fa fa-angle-right"></i>',
            prevArrow: '<i class="fa fa-angle-left"></i>',
            centerMode: true,
            centerPadding: '150px',
            infinite: true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        centerPadding: '50px'
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        centerPadding: '10px'
                    }
                }
            ]
        });
    }
    if($(".modal-content").length == 1) {
        modalSlick = $(".modal-content").slick({
            dots: false,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            nextArrow: '<i class="fa fa-angle-right"></i>',
            prevArrow: '<i class="fa fa-angle-left"></i>',
            infinite: true,
            fade: true,
            cssEase: 'linear',
            adaptiveHeight: true
        });
    }
    if($(window).width() <= 767) {
        $('.top').click(function(event){
            $('html, body').animate({
                scrollTop: 0
            }, 500);
            return false;
        });
        var waypoint = new Waypoint({
            element: document.getElementById('header'),
            handler: function() {
                $(".top").toggleClass('show');
            },
            offset: -500
        });
    }
});
function openModal(pos) {
    var $ = jQuery;
    $("#projectModal").addClass('fadeIn');
    $('.modal-content').slick('slickGoTo', pos);
    $('.modal-content').css('opacity',1);
}
function closeModal() {
    var $ = jQuery;
    $('.modal-content').css('opacity',0);
    $("#projectModal").removeClass('fadeIn');
}
function filter(id)
{
    var $ = jQuery;
    $.ajax({
        url: ajaxurl + "?action=ajax&call=filterProjects&gallery_id=" + id,
        cache: false,
        success: function (response) {
            $(".gallery-section").html(response).fadeIn();
            var $container = $(".grid");
            $container.imagesLoaded(function () {
                $container.masonry({
                    itemSelector: '.grid-item'
                });
            });
        },
        complete: function () {
            $.ajax({
                url: ajaxurl + "?action=ajax&call=updateModalSlides&gallery_id=" + id,
                cache: false,
                success: function (response) {
                    if ($('.modal-content').hasClass('slick-initialized')) {
                        $('.modal-content').slick('destroy');
                    }
                    $(".modal-content").html(response);
                    modalSlick = $(".modal-content").slick({
                        dots: false,
                        speed: 300,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        nextArrow: '<i class="fa fa-angle-right"></i>',
                        prevArrow: '<i class="fa fa-angle-left"></i>',
                        infinite: true,
                        fade: true,
                        cssEase: 'linear',
                        adaptiveHeight: true
                    });
                }
            });
        }
    });
}