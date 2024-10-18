const list = [
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" },
    { url: "#", img: "" }
]

function initCards(categoryList = list) {
    let container = document.getElementById("container");
    let cards = [];
    container.innerHTML = "";

    let numOfCardsPerRow = Math.floor((window.innerWidth - 64) / 120);
    let numOfCardsPerCol = Math.floor((window.innerHeight - 280) / 120);
    let numOfCardsPerPanel = numOfCardsPerRow * numOfCardsPerCol;
    let numofPanel = Math.ceil(categoryList.length / numOfCardsPerPanel);
    let indexofPanel = 0;
    
    let gapX = (window.innerWidth - 64 - 100 * numOfCardsPerRow) / (numOfCardsPerRow + 1);
    let gapY = (window.innerHeight - 280 - 100 * numOfCardsPerCol) / (numOfCardsPerCol + 1);
    
    
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

    function createOneCard(num) {
        let elem = document.createElement("div");
        elem.style.position = "absolute";
        elem.style.width = "100px";
        elem.style.height = "100px";
        elem.style.borderRadius = "10px";
        elem.style.border = "1px solid white";
        elem.style.backgroundColor = "rgba(255, 255, 255, 0.2)";
        elem.style.transition = "all 0.5s";
        elem.style.display = "flex";
        elem.style.justifyContent = "center";
        elem.style.alignItems = "center";
        elem.innerHTML = num;
        return elem;
    }

    function placeCards() {
        for (let i = 0; i < categoryList.length; i++) {
            let card = createOneCard(i + 1);
            cards.push(card);
            container.appendChild(card);
        }
    }

    function arrangeCards() {
        for (let j = 0; j < cards.length; j++) {
            let i = j % numOfCardsPerPanel;
            
            cards[j].style.left = (window.innerWidth - 64) * (Math.floor(j / numOfCardsPerPanel) - indexofPanel) + (i % numOfCardsPerRow + 1) * gapX + (i % numOfCardsPerRow) * 100 + "px";
            cards[j].style.top = Math.floor(i / numOfCardsPerRow + 1) * gapY + Math.floor(i/ numOfCardsPerRow) * 100 + "px";
        }
    }

    btnStateUpdate();
    placeCards();
    arrangeCards();

    window.addEventListener("resize", () => {
        numOfCardsPerRow = Math.floor((window.innerWidth - 64) / 120);
        numOfCardsPerCol = Math.floor((window.innerHeight - 280) / 120);
        numOfCardsPerPanel = numOfCardsPerRow * numOfCardsPerCol;
        numofPanel = Math.ceil(categoryList.length / numOfCardsPerPanel);
        
        if (indexofPanel >= numofPanel) {
            indexofPanel = numofPanel - 1;
        }

        gapX = (window.innerWidth - 64 - 100 * numOfCardsPerRow) / (numOfCardsPerRow + 1);
        gapY = (window.innerHeight - 280 - 100 * numOfCardsPerCol) / (numOfCardsPerCol + 1);
        
        btnStateUpdate();
        arrangeCards();
    })

    document.getElementById("prev").addEventListener("click", () => {
        if (indexofPanel > 0) {
            indexofPanel--;
            btnStateUpdate();
            arrangeCards();
        }
    });

    document.getElementById("next").addEventListener("click", () => {
        if (indexofPanel < numofPanel - 1) {
            indexofPanel++;
            btnStateUpdate();
            arrangeCards();
        }
    });
}
