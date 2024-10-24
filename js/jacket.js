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
    window.addEventListener("resize", () => {
        updateCardSize();
    });
    
}

function initSlick() {
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
    });

    // Detect when the user stops touching or clicking
    $('.slider').on('mouseup touchend', function (e) {
        if (Math.abs(e.pageX - startX) > threshold) {
            moved = true;
        }
    });

    $('.jacket-card').on('click', function () {
        if (!moved) {

            /**
             * When we click an jacket item, we send jQuery Ajax Request with jacket/book id value to equivalent php file 
             * which send response with detailed info of that book.
             * Then, we can get response. The response should be array with several required values(like Copies, Summary, Reading Levels, availability, type, title, etc). 
             * In this case, each item of array should be html element which implement the equivalent content or string value.
             * Then, according to the response, we update the modal content using jQuery.
             * After that, we show/open the modal.
             * Below code parts impelemt these steps.
             */

            // AJAX call to fetch modal content
            
            
            let jacketID = $(this).data("id");
            $.ajax({
                url: 'fetch_modal_content.php', // URL to fetch content (maybe you already have it.)
                type: 'POST', // If then, you can get the request value(jacket/boot ID) using $_POST['id]
                data: { id: jacketID }, // This is the request value
                success: function (response) { // If the request is successful and get response,
                    // then update modal body with response
                    let detailInfo = JSON.parse(response);

                    console.log(detailInfo);
                    

                    $("#cover-img").attr("src", detailInfo.coverImgUrl);
                    $("#avail-img").attr("src", `assets/img/item/${detailInfo['status']}.png`);
                    $("#type-img").attr("src", `assets/img/item/${detailInfo['type']}.png`);
                    $("#title").html(detailInfo.title);
                    

                    // This is to make Copies part in Modal
                    let copiesHTML = "";

                    detailInfo.copies.forEach(copyItem => {
                        copiesHTML += `
                            <p class="text-gray subtitle">Shelf Location at ${copyItem.position}</p>
                            <table class="table table-bordered">
                                <thead class="t-head">
                                    <tr>
                                        <th scope="col">Collection</th>
                                        <th scope="col">Call Number</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                            `;
                        
                        copyItem.collections.forEach(collectionItem => {
                            copiesHTML += `
                                    <tr>
                                        <td>${collectionItem[0]}</td>
                                        <td>${collectionItem[1]}</td>
                                        <td class="fw-bold">${collectionItem[2]}</td>
                                    </tr>
                            `;
                        });

                        copiesHTML += `
                                </tbody>
                            </table>
                        `;
                    });

                    // This is to make Summary part in Modal
                    let summaryHTML = "";

                    summaryHTML += `
                        <div class="bg-blue-heading kalam">Summary</div>
                    `;

                    detailInfo.summary.forEach(summaryItem => {
                        summaryHTML += `
                            <p class="summary-content">${summaryItem}</p>
                        `;
                    });

                    // This is to make Reading Levels part in Modal
                    let levelsHTML = "";

                    let levelStrList = [
                        "Lexile Measure",
                        "AR Reading Level",
                        "AR Interest Level",
                        "AR Points"
                    ]

                    detailInfo.levels.forEach((levelItem, index) => {
                        if (levelItem) {
                            levelsHTML += `
                                <div class="d-flex flex-column">
                                    <div class="fw-bold">${levelStrList[index]}</div>
                                    <span class="neg-margin">${levelItem}</span>
                                </div>
                            `;
                        }
                    })

                    // This is to make Details part in Modal
                    let detailsHTML = "";

                    if (detailInfo.details.author.length) { // If there is author list in detail information
                        detailsHTML += `
                            <div class="d-flex flex-column my-1">
                                <div class="fw-bold">It's by</div>
                        `;

                        detailInfo.details.author.forEach(author => {
                            detailsHTML += `
                                <a href="book_jacket.php?filterTerm=author&author=${author}" class="text-decoration-none neg-margin">${author}, author.</a>
                            `;
                        })

                        detailsHTML += `
                            </div>
                        `;
                    }

                    if (detailInfo.details.belongs.length) { // If there is belongs list in detail information
                        detailsHTML += `
                            <div class="d-flex flex-column my-1">
                                <div class="fw-bold">It's part of the series</div>
                        `;

                        detailInfo.details.belongs.forEach(belong => {
                            detailsHTML += `
                                <a href="book_jacket.php?filterTerm=seriesTitle&seriesTitle=${belong}" class="text-decoration-none neg-margin">${belong}</a>
                            `;
                        });
                        
                        detailsHTML += `
                            </div>
                        `;
                    }

                    if (detailInfo.details.length) { // If there is belongs list in detail information
                        detailsHTML += `
                            <div class="d-flex flex-column mt-2">
                                <div class="fw-bold">Length</div>
                                <span class="neg-margin">${detailInfo.details.length}</span>
                            </div>
                        `;
                    }

                    if (detailInfo.details.relates.length) { // If there is author list in detail information
                        detailsHTML += `
                            <div class="d-flex flex-column my-1">
                                <div class="fw-bold">Related Things</div>
                        `;

                        detailInfo.details.relates.forEach(relatedItem => {
                            detailsHTML += `
                                <a href="book_jacket.php?filterTerm=searchBox&searchBox=${relatedItem}" class="text-decoration-none neg-margin">${relatedItem}</a>
                            `;
                        })

                        detailsHTML += `
                            </div>
                        `;
                    }

                    // Then update the Modal content using above values
                    $("#copies")   .html(copiesHTML);
                    $("#summary")  .html(summaryHTML);
                    $("#levels")   .html(levelsHTML);
                    $("#details")  .html(detailsHTML);

                    $("#modal").css("display", "flex"); // After then, Show the modal
                }
            });
            
            
            // For now, I make this code parts as comment because you should modify according to your strategy
            // Once if you modify, then activate the commented parts above and make this below line as a comment
        }
    });

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
        let items = ["#copies-container", "#summary", "#levels-container", "#details-container"];
        let target = $(this).data("to");
        let restItems = items.filter(item => item !== `#${target}`);

        $(restItems.join(", ")).animate({ opacity: 0.5 }, 100);
        $("#" + target).animate({ opacity: 1 }, 100);
    })

    $(".action-btn.yes").click(function () {
        $(".login").css("display", "flex");
        $(".dogSaying .confirm").css("display", "none");
        $(".dogSaying .loading").css("display", "none");
        $(".dogSaying .suggest").css("display", "block");
        $(".dogSaying").css("z-index", "100001");
    })

    $(".action-btn.no").click(function () {
        $(".dogSaying .confirm").css("display", "none");
        $(".dogImg").css("z-index", "10");
        $(".dogSaying").css("display", "none");
    })

    $(".placehold").click(function () {
        $(".dogSaying").css("display", "block");
        $(".dogSaying .confirm").css("display", "block");
        $(".dogSaying .suggest").css("display", "none");
        $(".dogSaying .loading").css("display", "none");
        $(".dogSaying").css("z-index", "100001");
        $(".dogImg").css("z-index", "100000");
    })
    
    $(".forget").click(function () {
        $(".login").css("display", "none");
        $(".dogSaying").css("display", "none");
        $(".dogImg").css("z-index", "10");
    })
}