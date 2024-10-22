<?php
    # similar to the category page
    # lots security and mysql data code goes here
    
    # Open a database and select series records from series table
    # which contains a name and search strategy
    # While loop through the find set  and create each series carasoul item with name and search strategy link
    # close daabase. 
    # name is like 'Arthur', seach is like 'seriestitles=author' 

    # mimic this below using just an array of records.
    # while through the array and creaet the series carousal

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Series</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/category.css" rel="stylesheet">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container-fluid vh-100 main">
        <div class="position-absolute cloudBg" id="cloud">
            <img src="assets/img/bg/cloud-2.png" alt="cloud-1" />
            <img src="assets/img/bg/cloud-2.png" alt="cloud-2" style="transform: translate(0, 100px);" />
            <img src="assets/img/bg/cloud-2.png" alt="cloud-1" />
            <img src="assets/img/bg/cloud-2.png" alt="cloud-2" style="transform: translate(0, 100px);" />
            <img src="assets/img/bg/cloud-2.png" alt="cloud-1" />
        </div>
        <form class="search px-5 d-flex flex-row justify-content-center align-items-center" action="book_jacket.html">
            <input type="text" class="form-control" />
            <button type="submit" class="searchBtn mx-2">Search</button>
        </form>
        <div class="title rounded-4 px-3 d-flex align-items-center text-black">
            Series & Chapter Books
        </div>
        <div class="content overflow-hidden">
            <div class="prevBtn" id="prev"></div>
            <div class="nextBtn" id="next"></div>
            <div id="container" class="position-relative w-100 h-100">
            </div>
        </div>
    </div>

    <div class="footer fixed-bottom w-100">
        <div class="grass w-100" id="grass">
            <img src="assets/img/bg/grass-30.png" width="auto" />
        </div>
        <a href="category.html" class="dogImg">
            <img src="assets/img/item/dog.png" alt="dog" />
        </a>
        <a href="category.html" class="dogHouse">
            <img src="assets/img/item/doghouse.png" alt="dogHouse" />
        </a>
        <div class="footerContent rounded-4 d-flex justify-content-between px-4">
            <a class="d-flex flex-column text-decoration-none footer-item" href="category.html">
                <div class="imgBtn d-flex">
                    <div class="imgBtnItem item1 p-1">
                        <img src="./assets/img/categories/on (1).png" class="w-100 h-100" />
                    </div>
                    <div class="imgBtnItem item2 p-1">
                        <img src="./assets/img/categories/on (2).png" class="w-100 h-100" />
                    </div>
                    <div class="imgBtnItem item3 p-1">
                        <img src="./assets/img/categories/on (3).png" class="w-100 h-100" />
                    </div>
                    <div class="imgBtnItem item4 p-1">
                        <img src="./assets/img/categories/on (4).png" class="w-100 h-100" />
                    </div>
                </div>
                <span>Explore Categories</span>
            </a>
            <a class="d-flex flex-column text-decoration-none footer-item" href="series.html">
                <div class="imgBtn d-flex">
                    <div class="imgBtnItem item1 p-1">
                        <img src="./assets/img/categories/on (5).png" class="w-100 h-100" />
                    </div>
                    <div class="imgBtnItem item2 p-1">
                        <img src="./assets/img/categories/on (6).png" class="w-100 h-100" />
                    </div>
                    <div class="imgBtnItem item3 p-1">
                        <img src="./assets/img/categories/on (7).png" class="w-100 h-100" />
                    </div>
                    <div class="imgBtnItem item4 p-1">
                        <img src="./assets/img/categories/on (8).png" class="w-100 h-100" />
                    </div>
                </div>
                <span>Chapter & Series</span>
            </a>
        </div>
        <div class="footerBar w-100 d-flex overflow-visible">
            <a href="#" class="text-white text-decoration-none">Library Catalog</a>
            <a href="#" class="text-white text-decoration-none mx-3">Francais (Cambiar idioma)</a>
            <div class="flex-grow-1"></div>
            <a href="#" class="text-white text-decoration-none address">
                <span class="a">Eastern</span>
                <span class="b">Panhandle</span>
                <span class="c">Library</span>
                <span class="d">Consortium</span>
            </a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="./js/scripts.js"></script>
    <script>
        const serieslist = [
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
            ]
        initCards(serieslist, 160, ( window.innerHeight - 360 ) / 2);

    </script>
</body>

</html>