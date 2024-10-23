function initCards(cardW, cardH, term) {
    let cards = document.getElementsByClassName("custom-card");

    let numOfCardsPerRow = Math.floor((window.innerWidth - 64) / (cardW + 20));
    let numOfCardsPerCol = Math.floor((window.innerHeight - 280) / (cardH + 20));
    let numOfCardsPerPanel = numOfCardsPerRow * numOfCardsPerCol;
    let numofPanel = Math.ceil(cards.length / numOfCardsPerPanel);
    let indexofPanel = 0;
    
    let gapX = (window.innerWidth - 64 - cardW * numOfCardsPerRow) / (numOfCardsPerRow + 1);
    let gapY = (window.innerHeight - 280 - cardH * numOfCardsPerCol) / (numOfCardsPerCol + 1);

    let cloudX = 0;
    let grassX = 0;
    let moved = false;

    function initTouchEventForSlider() {
        let startX = 0;
        let threshold = 20; // Minimum swipe distance to consider as swipe

        // Detect when the user starts touching or clicking
        $('#container').on('mousedown touchstart', function (e) {
            moved = false;
            startX = e.pageX || e.originalEvent.touches[0].pageX;
        });

        // Detect when the user stops touching or clicking
        $('#container').on('mouseup touchend', function (e) {
            let delta = e.pageX - startX;

            if (Math.abs(delta) > threshold) {
                moved = true;
                if (delta < 0 && indexofPanel < numofPanel - 1) {
                    indexofPanel++;
                    btnStateUpdate();
                    arrangeCards();
                    assetsTransform(+1);
                }

                if (delta > 0 && indexofPanel > 0) {
                    indexofPanel--;
                    btnStateUpdate();
                    arrangeCards();
                    assetsTransform(-1);
                }
            }
        });
    }
    
    
    function btnStateUpdate() {
        if (indexofPanel <= 0) {
            document.getElementById("prev").style.backgroundPositionY = "-70px";
        } else {
            document.getElementById("prev").style.backgroundPositionY = "0px";
        }
        if (indexofPanel >= numofPanel - 1) {
            document.getElementById("next").style.backgroundPositionY = "-350px";
        } else {
            document.getElementById("next").style.backgroundPositionY = "-280px";
        }
    }

    function assetsTransform(dir) {
        let cloud = document.getElementById("cloud");
        let grass = document.getElementById("grass");
        cloudX += 100 * dir;
        grassX += 120 * dir;
        cloud.style.transform = `translate(${cloudX}px, 0)`;
        grass.style.right = `${grassX}px`;
    }

    function arrangeCards() {
        for (let j = 0; j < cards.length; j++) {
            let i = j % numOfCardsPerPanel;
            
            cards[j].style.left = (window.innerWidth - 64) * (Math.floor(j / numOfCardsPerPanel) - indexofPanel) + (i % numOfCardsPerRow + 1) * gapX + (i % numOfCardsPerRow) * cardW + "px";
            cards[j].style.top = Math.floor(i / numOfCardsPerRow + 1) * gapY + Math.floor(i/ numOfCardsPerRow) * cardH + "px";
        }
    }

    btnStateUpdate();
    arrangeCards();
    initTouchEventForSlider();

    window.addEventListener("resize", () => {
        numOfCardsPerRow = Math.floor((window.innerWidth - 64) / (cardW + 20));
        numOfCardsPerCol = Math.floor((window.innerHeight - 280) / (cardH + 20));
        numOfCardsPerPanel = numOfCardsPerRow * numOfCardsPerCol;
        numofPanel = Math.ceil(cards.length / numOfCardsPerPanel);
        
        if (indexofPanel >= numofPanel) {
            indexofPanel = numofPanel - 1;
        }

        gapX = (window.innerWidth - 64 - cardW * numOfCardsPerRow) / (numOfCardsPerRow + 1);
        gapY = (window.innerHeight - 280 - cardH * numOfCardsPerCol) / (numOfCardsPerCol + 1);
        
        btnStateUpdate();
        arrangeCards();
    })

    document.getElementById("prev").addEventListener("click", () => {
        if (indexofPanel > 0) {
            indexofPanel--;
            btnStateUpdate();
            arrangeCards();
            assetsTransform(-1);
        }
    });

    document.getElementById("next").addEventListener("click", () => {
        if (indexofPanel < numofPanel - 1) {
            indexofPanel++;
            btnStateUpdate();
            arrangeCards();
            assetsTransform(+1);
        }
    });

    $(".custom-card").css("width", `${cardW}px`);
    $(".custom-card").css("height", `${cardH}px`);
    
    $(".custom-card").click(function () {
        let id = $(this).data("id");
        window.location.href = `book_jacket.php?filterTerm=${term}&${term}=${id}`;
    })

}
