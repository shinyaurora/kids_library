function updateCardSize() {
    if (window.innerWidth > 1366) {
        $(".jacket-card").css("height", (window.innerWidth - 90 - 20 * 4) / 5 * 1.3 + "px");
    }
    if (window.innerWidth > 1024 && window.innerWidth <= 1366) {
        $(".jacket-card").css("height", (window.innerWidth - 90 - 20 * 3) / 4 * 1.3 + "px");
    }
    if (window.innerWidth > 768 && window.innerWidth < 1024) {
        $(".jacket-card").css("height", (window.innerWidth - 90 - 20 * 2) / 3 * 1.3 + "px");
    }
}

function initCardSizeOption() {
    updateCardSize();
    window.addEventListener("resize", updateCardSize);
}

function initSlick() {
    console.log("okok");
    
    $(".jacket-container").slick({
        slidesToShow: 5,
        slidesToScroll: 5,
        infinite: true,
        responsive: [
            {
                breakpoint: 1366,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    infinite: true,
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true
                }
            }
        ]
    });
}

function initModalEffects() {
    var moved = false;
    var startX = 0;
    var startY = 0;
    var threshold = 50; // Minimum swipe distance to consider as swipe

    // Detect when the user starts touching or clicking
    $('.slider').on('mousedown touchstart', function (e) {
        moved = false;
        startX = e.pageX || e.originalEvent.touches[0].pageX;
        startY = e.pageY || e.originalEvent.touches[0].pageY;
        console.log("down");
        
    });

    // Detect when the user stops touching or clicking
    $('.slider').on('mouseup touchend', function (e) {
        if (Math.abs(e.pageX - startX) > threshold) {
            moved = true;
        }
    });

    $(".jacket-card").click(function () {
        if (!moved) {
            $("#modal").css("display", "flex");
        }
    })

    $(".close-btn, .overlay").click(function () {
        $("#modal").css("display", "none");
    })

    $(".modal-link").click(function () {
        let target = $(this).data("to");
        let $targetElement = $("#" + target);
        $('.right-section').animate({
            scrollTop: $targetElement.offset().top - $('.right-section').offset().top + $('.right-section').scrollTop() - 15
        }, 300);
    });

    $(".links").mouseleave(function () {
        let items = ["#copies", "#summary", "#levels", "#details"];
        $(items.join(", ")).animate({ opacity: 1 }, 100);
    })

    $(".modal-link").mouseover(function () {
        let items = ["#copies", "#summary", "#levels", "#details"];
        let target = $(this).data("to");
        let restItems = items.filter(item => item !== `#${target}`);

        $(restItems.join(", ")).animate({ opacity: 0.5 }, 100);
        $("#" + target).animate({ opacity: 1 }, 100);
    })

    $(".action-btn.yes").click(function () {
        $(".login").css("display", "flex");
        $(".dogSaying .confirm").css("display", "none");
        $(".dogSaying .suggest").css("display", "block");
        $(".dogSaying").css("z-index", "100001");
    })
    
    $(".placehold").click(function () {
        $(".dogSaying").css("display", "block");
        $(".dogSaying .confirm").css("display", "block");
        $(".dogSaying").css("z-index", "100001");
        $(".dogImg").css("z-index", "100000");
    })
    
    $(".forget").click(function () {
        $(".login").css("display", "none");
        $(".dogSaying").css("display", "none");
        $(".dogImg").css("z-index", "10");
    })
}