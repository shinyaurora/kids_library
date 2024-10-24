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

    ########################################################
    # Modify code goes here. You can reference below code. #
    ########################################################

    # Let's assume that you got this result array by mysql code
    $result = [
        [
            "name"   => "Author 1",
            "imgUrl" => "assets/img/series/on (1).jpeg"
        ], [
            "name"   => "Author 2",
            "imgUrl" => "assets/img/series/on (2).jpeg"
        ], [
            "name"   => "Author 3",
            "imgUrl" => "assets/img/series/on (3).jpeg"
        ], [
            "name"   => "Author 4",
            "imgUrl" => "assets/img/series/on (4).jpeg"
        ], [
            "name"   => "Author 5",
            "imgUrl" => "assets/img/series/on (5).jpeg"
        ], [
            "name"   => "Author 6",
            "imgUrl" => "assets/img/series/on (6).jpeg"
        ], [
            "name"   => "Author 7",
            "imgUrl" => "assets/img/series/on (7).jpeg"
        ], [
            "name"   => "Author 8",
            "imgUrl" => "assets/img/series/on (8).jpeg"
        ], [
            "name"   => "Author 9",
            "imgUrl" => "assets/img/series/on (9).jpeg"
        ], [
            "name"   => "Author 10",
            "imgUrl" => "assets/img/series/on (10).jpeg"
        ], [
            "name"   => "Author 11",
            "imgUrl" => "assets/img/series/on (11).jpeg"
        ], [
            "name"   => "Author 12",
            "imgUrl" => "assets/img/series/on (12).jpeg"
        ], [
            "name"   => "Author 13",
            "imgUrl" => "assets/img/series/on (13).jpeg"
        ], [
            "name"   => "Author 14",
            "imgUrl" => "assets/img/series/on (14).jpeg"
        ], [
            "name"   => "Author 15",
            "imgUrl" => "assets/img/series/on (15).jpeg"
        ], [
            "name"   => "Author 16",
            "imgUrl" => "assets/img/series/on (16).jpeg"
        ], [
            "name"   => "Author 17",
            "imgUrl" => "assets/img/series/on (17).jpeg"
        ], [
            "name"   => "Author 18",
            "imgUrl" => "assets/img/series/on (18).jpeg"
        ], [
            "name"   => "Author 19",
            "imgUrl" => "assets/img/series/on (19).jpeg"
        ], [
            "name"   => "Author 20",
            "imgUrl" => "assets/img/series/on (20).jpeg"
        ], [
            "name"   => "Author 21",
            "imgUrl" => "assets/img/series/on (21).jpeg"
        ], [
            "name"   => "Author 22",
            "imgUrl" => "assets/img/series/on (22).jpeg"
        ], [
            "name"   => "Author 23",
            "imgUrl" => "assets/img/series/on (23).jpeg"
        ], [
            "name"   => "Author 24",
            "imgUrl" => "assets/img/series/on (24).jpeg"
        ], [
            "name"   => "Author 25",
            "imgUrl" => "assets/img/series/on (25).jpeg"
        ], [
            "name"   => "Author 26",
            "imgUrl" => "assets/img/series/on (26).jpeg"
        ], [
            "name"   => "Author 27",
            "imgUrl" => "assets/img/series/on (27).jpeg"
        ], [
            "name"   => "Author 28",
            "imgUrl" => "assets/img/series/on (28).jpeg"
        ], [
            "name"   => "Author 29",
            "imgUrl" => "assets/img/series/on (29).jpeg"
        ], [
            "name"   => "Author 30",
            "imgUrl" => "assets/img/series/on (30).jpeg"
        ]
    ];
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
        <form class="search px-5 d-flex flex-row justify-content-center align-items-center" action="book_jacket.php" type="get">
            <input type="text" name="filterTerm" value="searchBox" hidden />
            <input type="text" class="form-control" name="searchBox" />
            <button type="submit" class="searchBtn mx-2">Search</button>
        </form>
        <div class="title rounded-4 px-3 d-flex align-items-center text-black">
            Series & Chapter Books
        </div>
        <div class="content overflow-hidden">
            <div class="prevBtn" id="prev"></div>
            <div class="nextBtn" id="next"></div>
            <div id="container" class="position-relative w-100 h-100">

                <!-- I modified the code here -->
                <?php

                    foreach($result as $item) {
                        echo "<div class=\"custom-card d-flex justify-content-center align-align-items-center\" title=\"".$item['name']."\" data-id=\"".$item["name"]."\">".
                                "<img src=\"".$item['imgUrl']."\" draggable=\"false\" >".
                             "</div>";
                    };
                ?>
                <!-- ======================== -->

            </div>
        </div>
    </div>

    <div class="footer fixed-bottom w-100">
        <div class="grass w-100" id="grass">
            <img src="assets/img/bg/grass-30.png" width="auto" />
        </div>
        <a href="category.php" class="dogImg">
            <img src="assets/img/item/dog.png" alt="dog" />
        </a>
        <a href="category.php" class="dogHouse">
            <img src="assets/img/item/doghouse.png" alt="dogHouse" />
        </a>
        <div class="footerContent rounded-4 d-flex justify-content-between px-4">
            <a class="d-flex flex-column text-decoration-none footer-item" href="category.php">
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
            <a class="d-flex flex-column text-decoration-none footer-item" href="series.php">
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
    <script src="./js/script.js"></script>
    <script>
        initCards(160, ( window.innerHeight - 360 ) / 2, "seriesId");
    </script>
</body>

</html>