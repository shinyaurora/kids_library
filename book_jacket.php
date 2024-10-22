
<?php

    # lots security and mysql data code goes here
    
    # Open a library database 
    # retrieve search term 
    # $term = $_GET['term'];
    # this could be comingfrom the Search From or category link or series link
    # Select the catalog records from the library catalog table
    # While loop through the find set  and create each book jacket carasoul item with 
    # catalog record information book jacket, chich is in the catalog record.
    # records contains fields like title, author, cover_id. 
    # close daabase. 

  
    # mimic this below using just an array of records.
    # while through the array and creaet the book jacket carousal
    
    # question?  how to link the modal dialog box (catalog record information) to each record?  Do I include that in theformation of the carousal?

    ########################################################
    # Modify code goes here. You can reference below code. #
    ########################################################

    # This is code for gettring search term and search content
    $term = isset($_GET['filterTerm']) ? $_GET['filterTerm'] : ""; 
    $search = $term ? $_GET[$term] : "";
    # You can use these values for mysql query to select corresponding filtered result

    # I will skip the SQL code

    # Let's assume that you got below result array by mysql query above.
    $result = [
        [
            "id"     => "1",
            "title"  => "What Is The Story of Hello Kitty?",
            "status" => "in",
            "type"   => "book",
            "level"  => "30L",
            "imgUrl" => "./assets/img/jackets/image1.jpeg"
        ], [
            "id"     => "2",
            "title"  => "Waylon! One Awesome Thing",
            "status" => "out",
            "type"   => "dvd",
            "level"  => "530L",
            "imgUrl" => "./assets/img/jackets/image2.jpeg"
        ], [
            "id"     => "3",
            "title"  => "DIARY OF A MINECRAFT ZOMBIE",
            "status" => "in",
            "type"   => "book",
            "level"  => "210L",
            "imgUrl" => "./assets/img/jackets/image3.jpeg"
        ], [
            "id"     => "4",
            "title"  => "Life according to Og the Frog",
            "status" => "in",
            "type"   => "dvd",
            "level"  => "10L",
            "imgUrl" => "./assets/img/jackets/image4.jpeg"
        ], [
            "id"     => "5",
            "title"  => "There's a Monter IN YOUR BOOK",
            "status" => "out",
            "type"   => "book",
            "level"  => "80L",
            "imgUrl" => "./assets/img/jackets/image5.jpeg"
        ], 
    ];

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Jacket <?php echo $term ?></title>
    <link rel="stylesheet" type="text/css" href="css/global.css">
    <link rel="stylesheet" type="text/css" href="css/book_jacket.css">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/slick.css" />
    <link rel="stylesheet" type="text/css" href="css/slick-theme.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@300;400;700&display=swap" rel="stylesheet" />
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
        <div class="search px-5 d-flex flex-row justify-content-center align-items-center">
            <input type="text" required class="form-control" />
            <button type="button" class="searchBtn mx-2">Search</button>
        </div>
        <div class="title rounded-4 px-3 d-flex align-items-center text-black">
            <!-- Place the number of result here -->
            <span id="numResults">100</span>
            <span style="margin: 0px 8px;">Results for</span>
            <!-- Place the name of category here -->
            <span id="catName">Cats</span>
        </div>
        <div class="content overflow-hidden">
            <div class="prevBtn" id="prev"></div>
            <div class="nextBtn" id="next"></div>
            <div class="jacket-container slider" id="container">
                
                <!-- -------------------------------------------- -->
                <!--  This is for exporint the card item elements -->
                <!-- -------------------------------------------- -->
                    <?php
                        foreach($result as $item) {
                            echo "<div>".
                                    "<div class='jacket-card d-flex justify-content-center align-items-center position-relative'>".
                                        "<div class='availability'>".
                                            "<img src='assets/img/item/".$item['status'].".png' />".
                                        "</div>".
                                        "<div class='type'>".
                                            "<img title='".$item['type']."' src='assets/img/item/".$item['type'].".png' />".
                                        "</div>".
                                        "<div class='level'>".
                                            "<img src='assets/img/item/pagecurl.png' />".
                                            "<span class='level-text' id='level-text'>".$item['level']."</span>".
                                        "</div>".
                                        "<img src='".$item['imgUrl']."' />".
                                    "</div>".
                                "</div>";
                        }
                    ?>
                <!-- -------------------------------------------- -->
                <!-- -------------------------------------------- -->

            </div>
        </div>
    </div>

    <!-- This is modal part -->
    <div id="modal">
        <!-- The contents of modal should be modified by JS or PHP  -->
        <div class="overlay"></div>
        <div class="d-flex flex-row shadow-sm rounded-7 center-box">
            <div class="left-section d-flex flex-column d-none d-md-block" >
                <div class="thumbnail position-relative">

                    <!-- These three image elements are modified by jQuery code -->
                    <img src="assets/img/jackets/image6.jpeg" alt="cover_page_img" class="w-100" id="cover-img" />
                    <img src="assets/img/item/in.png" alt="availability" class="detail-avai" id="avail-img" />
                    <img src="assets/img/item/book.png" alt="type" class="detail-type" id="type-img" />
                    <!-- =============================================================== -->

                </div>
                <button class="btn btn-style placehold">Place Hold</button>
                <div class="links d-flex flex-column align-items-end justify-content-end">
                    <a href="#" class="text-decoration-none kalam modal-link" data-to="copies">Copies</a>
                    <a href="#" class="text-decoration-none kalam modal-link" data-to="summary">Summary</a>
                    <a href="#" class="text-decoration-none kalam modal-link" data-to="levels">Reading Levels</a>
                    <a href="#" class="text-decoration-none kalam modal-link" data-to="details">Details</a>
                </div>
            </div>

            <div class="right-section d-flex flex-column overflow-auto flex-grow-1">

                <!-- Also the title will be modified  -->
                <h1 class="large-text" id="title">Wolves</h1>
                <!-- ===================================== -->

                <div id="copies">
                    <p class="bg-blue-heading kalam">Copies</p>
                    
                    <!-- These parts will be also modified -->
                    <div id="copies">
                        <p class="text-gray subtitle">Shelf Location at Keyser</p>
                        <table class="table table-bordered">
                            <thead class="t-head">
                                <tr>
                                    <th scope="col">Collection</th>
                                    <th scope="col">Call Number</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Juvenile Non-Fiction</td>
                                    <td>J 599.74 G</td>
                                    <td class="fw-bold">Checked In</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="text-gray subtitle">Shelf Location at Keyser</p>
                        <table class="table table-bordered">
                            <thead class="t-head">
                                <tr>
                                    <th scope="col">Collection</th>
                                    <th scope="col">Call Number</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Juvenile Non-Fiction</td>
                                    <td>J 599.74 Gibbons</td>
                                    <td class="fw-bold">Checked In</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- ============================================================= -->

                </div>
                <div id="summary">
                    <p class="bg-blue-heading margin-top kalam">Summary</p>

                    <!-- Also the summary will be modified  -->
                    <p class="summary-content" id="summary">Just how these long-feared animals live.</p>
                    <!-- ============================================================= -->

                </div>
                <div class="d-flex flex-column" id="levels">
                    <p class="bg-blue-heading margin-top kalam">
                        Reading Levels
                    </p>
                    
                    <!-- These parts will be also modified -->
                    <div id="levels">
                        <div class="d-flex flex-column gap-1">
                            <p class="fw-bold">Lexile Measure</p>
                            <p class="neg-margin">670L</p>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <p class="fw-bold">AR Reading Level</p>
                            <p class="neg-margin">4.2</p>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <p class="fw-bold">AR Interest Level</p>
                            <p class="neg-margin">MG</p>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <p class="fw-bold">AR Points</p>
                            <p class="neg-margin">0.5</p>
                        </div>
                    </div>
                    <!-- ============================================================= -->

                </div>
                <div class="d-flex flex-column" id="details">
                    <p class="bg-blue-heading margin-top kalam">Details</p>

                    <!-- These parts will be also modified -->
                    <div id="details">
                        <div class="d-flex flex-column gap-1">
                            <p class="fw-bold">Lexile Measure</p>
                            <a href="#" class="text-decoration-none neg-margin">Gibbons, Gail author</a>
                        </div>
                        <div class="d-flex flex-column gap-1 mt-2">
                            <p class="fw-bold">Lexile Measure</p>
                            <p class="neg-margin">1 volume (unpaged):</p>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <p class="fw-bold">Lexile Measure</p>
                            <a href="#" class="neg-margin text-decoration-none mb-2">Wolves -- Juvenile literature</a>
                            <a href="#" class="neg-margin text-decoration-none">Wolves.</a>
                        </div>
                    </div>
                    <!-- ============================================================= -->

                </div>
            </div>
            <img src="assets/img/item/close-button.png" alt="close" class="close-btn"/>
        </div>
    </div>

    <!-- This is a login form -->
    <div class="login justify-content-center">
        <div class="login-overlay"></div>
        <form class="login-content">
            <p>Log in with either your Library Card Number or EZ login</p>
            <div class="login-item my-3">
                <label for="id">Libary ID *</label>
                <input type="text" required name="id" id="id" class="form-control" />
            </div>
            <div class="login-item my-3">
                <label for="pin">PIN *</label>
                <input type="text" required name="pin" id="pin" class="form-control" />
            </div>
            <div class="login-item my-3 d-flex align-items-center">
                <input type="checkbox" id="remember" name="remember" class="form-check mx-1" />
                <label for="remember">Remember Me</label> 
            </div>
            <div class="login-action d-flex justify-content-between">
                <button type="submit" class="btn btn-primary btn-sm submit">I want it</button>
                <button type="reset" class="btn btn-secondary btn-sm forget">Forget it</button>
            </div>
        </form>
    </div>

    

    <div class="dogSaying" id="dogSaying">
        <div class="bubble top-left">
            <img src="./assets/img/item/message/top-left.png" alt="" role="presentation">
        </div>
        <div class="bubble top-middle">
            <img src="./assets/img/item/message/middle.png" alt="" role="presentation">
        </div>
        <div class="bubble top-right">
            <img src="./assets/img/item/message/top-right.png" alt="" role="presentation" data-nsfw-filter-status="sfw"
                style="visibility: visible;">
        </div>
        <div class="bubble middle-left">
            <img src="./assets/img/item/message/middle.png" alt="" role="presentation">
        </div>
        <div class="bubble middle-middle">
            <img src="./assets/img/item/message/middle.png" alt="" role="presentation">
        </div>
        <div class="bubble middle-right">
            <img src="./assets/img/item/message/middle.png" alt="" role="presentation">
        </div>
        <div class="bubble bottom-left">
            <img src="./assets/img/item/message/bottom-left.png" alt="" role="presentation" data-nsfw-filter-status="sfw"
                style="visibility: visible;">
        </div>
        <div class="bubble bottom-middle">
            <img src="./assets/img/item/message/middle.png" alt="" role="presentation">
        </div>
        <div class="bubble bottom-right">
            <img src="./assets/img/item/message/bottom-right.png" alt="" role="presentation" data-nsfw-filter-status="sfw"
                style="visibility: visible;">
        </div>
        <div class="say-content loading">Loading...</div>
        <div class="say-content confirm">
            <h3 class="my-1">Do you want the libary to save this for you?</h3>
            <!-- This part will be modified by book title -->
            <h4 class="my-3">Which one doesn't belong? :
                <span id="bookTitle">
                    playing with shapes
                </span>
            </h4>
            <div class="confirm-action d-flex justify-content-center">
                <div class="action-btn mx-2 yes">Yes</div>
                <div class="action-btn mx-2 no">No</div>
            </div>
        </div>
        <div class="say-content suggest">If you want it, login</div>
    </div>

    <a href="category.php" class="dogImg">
        <img src="assets/img/item/dog.png" alt="dog" />
    </a>

    <div class="footer w-100">
        <div class="grass w-100" id="grass">
            <img src="assets/img/bg/grass-30.png" width="auto" />
        </div>
        <a href="category.php" class="dogHouse">
            <img src="assets/img/item/doghouse.png" alt="dogHouse" />
        </a>

        <!-- When dogs saying, using JS DOM, can toggle the visibility during loading time -->
        <!-- And can change the saying content -->

        <!-- Once enter jaket page, then the category icon showes next to dog's house image -->
        <!-- It can also be changed with JS DOM easily here -->
        <div class="pageCat">
            <img src="assets/img/categories/on (1).png" id="pageCatImg" />
        </div>

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

    <!-- Here, the JS script goes -->
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="./js/slick.js" type="text/javascript" charset="utf-8"></script>
    <script src="./js/jacket.js" type="text/javascript" charset="utf-8"></script>
    <script>
        initCardSizeOption();
        initSlick();
        initModalEffects();

    </script>

</body>

</html>