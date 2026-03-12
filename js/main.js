$(document).ready(function(){
    var mobileBreakpoint = window.matchMedia('(max-width: 1000px)');

    function closeMobileNav() {
        $('.fa-bars').removeClass('fa-times');
        $('.navbar').removeClass('nav-toggle').removeAttr('style');
    }

    function syncHeaderState() {
        var isMobile = mobileBreakpoint.matches;

        if (!isMobile) {
            closeMobileNav();
        }

        if($(window).scrollTop()>35) {
            $('.header').addClass('scrolled');
        } else {
            $('.header').removeClass('scrolled');
        }
    }

    $('.fa-bars').click(function(){
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('nav-toggle');
    });

    $(window).on('load scroll',function(){
        closeMobileNav();
        syncHeaderState();
    });

    $(window).on('resize orientationchange pageshow', function () {
        syncHeaderState();
    });

    if (window.visualViewport) {
        $(window.visualViewport).on('resize', function () {
            syncHeaderState();
        });
    }

    const counters = document.querySelectorAll('.counter');
    const speed = 120;
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const inc = target / speed;
            if (count < target) {
                counter.innerText = count + inc;
                setTimeout(updateCount, 1);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });

    (function ($) {
        "use strict";

        $(".clients-carousel").owlCarousel({
            autoplay: true,
            dots: true,
            loop: true,
            responsive: { 0: {items: 2}, 768: {items: 4}, 900: {items: 6} }
        });

        $(".testimonials-carousel").owlCarousel({
            autoplay: true,
            dots: true,
            loop: true,
            responsive: { 0: {items: 1}, 576: {items: 2}, 768: {items: 3}, 992: {items: 4} }
        });

    })(jQuery);

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });

    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });

    // ===== Accordion exclusive open =====
    $('.accordion-header').click(function(){
        var $accordionBody = $(this).next('.accordion-body');
        var $span = $(this).children('span');

        // Close all other open accordions
        $('.accordion-body').not($accordionBody).slideUp(500);
        $('.accordion-header').not(this).children('span').text('+');

        // Toggle the clicked one
        $accordionBody.slideToggle(500);
        $span.text(function(_, currentText){
            return currentText === '+' ? '-' : '+';
        });
    });

    syncHeaderState();

});
