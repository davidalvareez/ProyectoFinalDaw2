$(document).ready(function() {
    $('.owl-carousel-1').owlCarousel({
        loop: false,
        margin: 10,
        items: 4,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    })
    $('.owl-carousel-2').owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    })
    $('.owl-carousel-4').owlCarousel({
        loop: false,
        margin: 10,
        items: 4,
        nav: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    })

    $(document).ready(function() {
        $(".btn-cerrarPop").click(function() {
            $("#overlay").removeClass('active');
            $("#popup").removeClass('active');

        });
        $(".btn-cerrarPop2").click(function() {
            $("#overlay").removeClass('active');
            $("#popup").removeClass('active');

        });
        $(".btn-abrirPop").click(function() {
            $("#overlay").addClass('active');
            $("#popup").addClass('active');
        });
    });
});