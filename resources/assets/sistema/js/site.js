$(function() {

    $('.login .drop').on('click', function() {
        $(this).parent().find('form').toggleClass('show');
    })

    $('.login .drop-menu').on('click', function() {
        $(this).parent().find('.sub').toggleClass('show');
    })

    $('.view_courses_post .subscriber').on('click', function() {
            if ($(this).parent().find('.planos').val() != '') {
                window.location.href = $(this).data('url') + '/' + $(this).parent().find('.planos').val();
            }
        })
        // slick slider
    $(".slick-banner").slick({
        dots: true,
        pauseOnDotsHover: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
        pauseOnHover: true,
        infinite: true,
        slidesToShow: 1
    });

    $(".slick-testemonials").slick({
        dots: true,
        pauseOnDotsHover: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
        pauseOnHover: true,
        infinite: true,
        slidesToShow: 3,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    $(".slick-courses-live").slick({
        dots: false,
        pauseOnDotsHover: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 3000,
        pauseOnHover: true,
        infinite: true,
        slidesToShow: 3,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    $(".slick-benefits").slick({
        dots: false,
        pauseOnDotsHover: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 3000,
        pauseOnHover: true,
        infinite: true,
        slidesToShow: 2,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 1
            }
        }]
    });

    $(".slick-teachers").slick({
        dots: false,
        pauseOnDotsHover: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 3000,
        pauseOnHover: true,
        infinite: true,
        variableWidth: true,
        slidesToShow: 4,
        responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    variableWidth: false
                }
            },
            {
                breakpoint: 512,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.section_courses_content a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $target = $(this).attr('href');
        $($target).find(".slick-courses").slick('destroy').slick(configsCourses());
    })

    // $(".slick-courses").slick(configsCourses());

    $('.slick-photo').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slick-gallery'
    });

    $('.slick-gallery').slick({
        arrows: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slick-photo',
        dots: false,
        focusOnSelect: true
    });

    $("[data-modal]").click(function(e) {
        e.preventDefault();
        atualizaCart();
        $($(this).data("modal")).addClass("show");
    });

    $("[data-close]").click(function(e) {
        e.preventDefault();

        // $($(this).data("close")).css("display", "none");
        $($(this).data("close")).removeClass("show");
    });

    //show text
    $("[data-show]").click(function(e) {
        e.preventDefault();

        $($(this).data("show")).css("height", "auto");
    });

    //step cart
    // $("[data-step]").click(function() {
    //     var id = $(this).data("step");
    //     var step = $(id);
    //     $("#cartSteps .nav-link").removeClass("active");
    //     $("#cartStepsContent > .tab-pane").removeClass("active");
    //     $("#cartStepsContent > .tab-pane").removeClass("show");
    //     $(id + '-tab').addClass("active");
    //     $(step).addClass("active");
    //     $(step).addClass("show");
    // });

    if ($("#calendar").length) {
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var calendarEl = document.getElementById('calendar');

        var calendar = new Calendar(calendarEl, {
            plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid'],
            header: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            'themeSystem': 'bootstrap',
            locale: 'pt-br',
            timeZone: 'America/Sao_Paulo'
        });

        calendar.render();
    }

    // scroll animate
    $("[data-go]").click(function(e) {
        e.preventDefault();
        // var goto = $($(this).data("go")).offset().top;
        // $("html, body").animate({ scrollTop: goto }, 1000, "easeOutBounce");
    });
});


function configsCourses() {
    return {
        dots: false,
        pauseOnDotsHover: true,
        arrows: false,
        autoplay: false,
        autoplaySpeed: 3000,
        pauseOnHover: true,
        infinite: false,
        slidesToShow: 3,
        rows: 2,
        slidesPerRow: 1,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    rows: 3
                }
            },
            {
                breakpoint: 512,
                settings: {
                    arrows: true,
                    slidesToShow: 1,
                    rows: 1
                }
            }
        ]
    };
}