<?php
    # lots security and mysql data code goes here
    
    # Open a database and select catetory records from category table
    # which contains a name and search strategy
    # While loop through the find set  and create each category carasoul item with name and search strategy link
    # close daabase. 
    # name is like 'Rabbits', seach is like 'rabbits' 

    # mimic this below using just an array of records.
    # while through the array and creaet the category carousal

    ##########################################################################
    # Let's Say that you got this result array like below using MySQL query. #
    ##########################################################################
    $result = [
        [
            "name" => "Rabbits 1",
            "imgUrl" => "assets/img/categories/on (1).png"
        ], [
            "name" => "Rabbits 2",
            "imgUrl" => "assets/img/categories/on (2).png"
        ], [
            "name" => "Rabbits 3",
            "imgUrl" => "assets/img/categories/on (3).png"
        ], [
            "name" => "Rabbits 4",
            "imgUrl" => "assets/img/categories/on (4).png"
        ], [
            "name" => "Rabbits 5",
            "imgUrl" => "assets/img/categories/on (5).png"
        ], [
            "name" => "Rabbits 6",
            "imgUrl" => "assets/img/categories/on (6).png"
        ], [
            "name" => "Rabbits 7",
            "imgUrl" => "assets/img/categories/on (7).png"
        ], [
            "name" => "Rabbits 8",
            "imgUrl" => "assets/img/categories/on (8).png"
        ], [
            "name" => "Rabbits 9",
            "imgUrl" => "assets/img/categories/on (9).png"
        ], [
            "name" => "Rabbits 10",
            "imgUrl" => "assets/img/categories/on (10).png"
        ], [
            "name" => "Rabbits 11",
            "imgUrl" => "assets/img/categories/on (11).png"
        ], [
            "name" => "Rabbits 12",
            "imgUrl" => "assets/img/categories/on (12).png"
        ], [
            "name" => "Rabbits 13",
            "imgUrl" => "assets/img/categories/on (13).png"
        ], [
            "name" => "Rabbits 14",
            "imgUrl" => "assets/img/categories/on (14).png"
        ], [
            "name" => "Rabbits 15",
            "imgUrl" => "assets/img/categories/on (15).png"
        ], [
            "name" => "Rabbits 16",
            "imgUrl" => "assets/img/categories/on (16).png"
        ], [
            "name" => "Rabbits 17",
            "imgUrl" => "assets/img/categories/on (17).png"
        ], [
            "name" => "Rabbits 18",
            "imgUrl" => "assets/img/categories/on (18).png"
        ], [
            "name" => "Rabbits 19",
            "imgUrl" => "assets/img/categories/on (19).png"
        ], [
            "name" => "Rabbits 20",
            "imgUrl" => "assets/img/categories/on (20).png"
        ], [
            "name" => "Rabbits 21",
            "imgUrl" => "assets/img/categories/on (21).png"
        ], [
            "name" => "Rabbits 22",
            "imgUrl" => "assets/img/categories/on (22).png"
        ], [
            "name" => "Rabbits 23",
            "imgUrl" => "assets/img/categories/on (23).png"
        ], [
            "name" => "Rabbits 24",
            "imgUrl" => "assets/img/categories/on (24).png"
        ], [
            "name" => "Rabbits 25",
            "imgUrl" => "assets/img/categories/on (25).png"
        ], [
            "name" => "Rabbits 26",
            "imgUrl" => "assets/img/categories/on (26).png"
        ], [
            "name" => "Rabbits 27",
            "imgUrl" => "assets/img/categories/on (27).png"
        ], [
            "name" => "Rabbits 28",
            "imgUrl" => "assets/img/categories/on (28).png"
        ], [
            "name" => "Rabbits 29",
            "imgUrl" => "assets/img/categories/on (29).png"
        ], [
            "name" => "Rabbits 30",
            "imgUrl" => "assets/img/categories/on (30).png"
        ]
    ];

    $jsonResult = json_encode($result);
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Category</title>
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
            <img src="assets/img/bg/cloud-2.png" alt="cloud-2" style="transform: translate(0, 100px);"  />
            <img src="assets/img/bg/cloud-2.png" alt="cloud-1" />
        </div>
        <form class="search px-5 d-flex flex-row justify-content-center align-items-center" action="book_jacket.html">
            <input type="text" class="form-control" />
            <button type="submit" class="searchBtn mx-2">Search</button>
        </form>
        <div class="title rounded-4 px-3 d-flex align-items-center text-black">
            Explore Categories
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
            <img src="assets/img/bg/grass-30.png" width="auto"/>
        </div>
        <a href="#" class="dogImg">
            <img src="assets/img/item/dog.png" alt="dog" />
        </a>
        <a href="#" class="dogHouse">
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
    <script src="./js/script.js"></script>
    <script>
        let list = <?php echo $jsonResult ?>;
        initCards(list, 140, 140);
    </script>
</body>

</html>