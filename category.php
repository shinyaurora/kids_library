<?php
    # lots security and mysql data code goes here
    
    # Open a database and select catetory records from category table
    # which contains a name and search strategy
    # While loop through the find set  and create each category carasoul item with name and search strategy link
    # close daabase. 
    # name is like 'Rabbits', seach is like 'rabbits' 

    # mimic this below using just an array of records.
    # while through the array and creaet the category carousal

    ########################################################
    # Modify code goes here. You can reference below code. #
    ########################################################

    # Let's assume that you got this result array by mysql code

    require_once("./pre.php");

    // $result = [
    //     [   "name"   => "Airplane", "imgUrl" => "assets/img/categories/Airplane.png"],   
    //     [   "name"   => "Basketball", "imgUrl" => "assets/img/categories/Basketball.png"], 
    //     [   "name"   => "Bird", "imgUrl" => "assets/img/categories/Bird.png"], 
    //     [   "name"   => "Car", "imgUrl" => "assets/img/categories/Car.png"],     
    //     [   "name"   => "Cars Racing", "imgUrl" => "assets/img/categories/Cars Racing.png"], 
    //     [   "name"   => "Christmas", "imgUrl" => "assets/img/categories/Christmas.png"], 
    //     [   "name"   => "Crabs", "imgUrl" => "assets/img/categories/Crabs.png"], 
    //     [   "name"   => "Deer", "imgUrl" => "assets/img/categories/Deer.png"], 
    //     [   "name"   => "Dinosaur", "imgUrl" => "assets/img/categories/Dinosaur.png"], 
    //     [   "name"   => "Dog", "imgUrl" => "assets/img/categories/Dog.png"], 
    //     [   "name"   => "Dragon", "imgUrl" => "assets/img/categories/Dragon.png"], 
    //     [   "name"   => "Easter", "imgUrl" => "assets/img/categories/Easter.png"], 
    //     [   "name"   => "Elephant", "imgUrl" => "assets/img/categories/Elephant.png"], 
    //     [   "name"   => "Fire Engine", "imgUrl" => "assets/img/categories/Fire Engine.png"],
    //     [   "name"   => "Fish", "imgUrl" => "assets/img/categories/Fish.png"], 
    //     [   "name"   => "Football", "imgUrl" => "assets/img/categories/Football.png"], 
    //     [   "name"   => "Fourth of July", "imgUrl" => "assets/img/categories/Fourth of July.png"], 
    //     [   "name"   => "Frog", "imgUrl" => "assets/img/categories/Frog.png"], 
    //     [   "name"   => "Golf", "imgUrl" => "assets/img/categories/Golf.png"], 
    //     [   "name"   => "Giraffe", "imgUrl" => "assets/img/categories/Giraffe.png"],
    //     [   "name"   => "Hippopotamus", "imgUrl" => "assets/img/categories/Hippopotamus.png"], 
    //     [   "name"   => "Holloween", "imgUrl" => "assets/img/categories/Holloween.png"], 
    //     [   "name"   => "Horse", "imgUrl" => "assets/img/categories/Horse.png"],  
    //     [   "name"   => "Ladybug", "imgUrl" => "assets/img/categories/Ladybug.png"],
    //     [   "name"   => "Money", "imgUrl" => "assets/img/categories/Money.png"], 
    //     [   "name"   => "Monkey", "imgUrl" => "assets/img/categories/Monkey.png"], 
    //     [   "name"   => "Moon", "imgUrl" => "assets/img/categories/Moon.png"],
    //     [   "name"   => "Olympic", "imgUrl" => "assets/img/categories/Olympic.png"], 
    //     [   "name"   => "Planet", "imgUrl" => "assets/img/categories/Planet.png"],
    //     [   "name"   => "Pigs", "imgUrl" => "assets/img/categories/Pigs.png"], 
    //     [   "name"   => "Pirate", "imgUrl" => "assets/img/categories/Pirate.png"], 
    //     [   "name"   => "Rabbitt", "imgUrl" => "assets/img/categories/Rabbitt.png"], 
    //     [   "name"   => "Rain", "imgUrl" => "assets/img/categories/Rain.png"], 
    //     [   "name"   => "Rainbow", "imgUrl" => "assets/img/categories/Rainbow.png"], 
    //     [   "name"   => "School Bus", "imgUrl" => "assets/img/categories/School Bus.png"], 
    //     [   "name"   => "Shark", "imgUrl" => "assets/img/categories/Shark.png"], 
    //     [   "name"   => "Teddy Bear", "imgUrl" => "assets/img/categories/Teddy Bear.png"], 
    //     [   "name"   => "Tennis", "imgUrl" => "assets/img/categories/Tennis.png"],  
    //     [   "name"   => "Tiger", "imgUrl" => "assets/img/categories/Tiger.png"], 
    //     [   "name"   => "Train", "imgUrl" => "assets/img/categories/Train.png"], 
    //     [   "name"   => "Truck", "imgUrl" => "assets/img/categories/Truck.png"], 
    //     [   "name"   => "Whale", "imgUrl" => "assets/img/categories/Whale.png"], 
    //     [   "name"   => "Zebra", "imgUrl" => "assets/img/categories/Zebra.png"], 

    // ];
    
    # This should all be done in a header file after index file and before category file to 
    # load the array and check to make sure there are records for each icon.
    # here - show how to add additinal category icons from a text files to array one at a time. 
    # name[tab]filename.png[cr]
    


    
    # ############################################################################
    # Get the library name and other options from the library table
    ##############################################################################
    require_once("/library/webserver/cgi-executables/kids_ini.php");
    date_default_timezone_set('America/Los_Angeles');

    
    $library_id = $_GET['library_id'];
    
    if ($library_id == '') {
             header("location:https://opac.libraryworld.com");
             exit;
    }
    
     
     $database = "libraryworld";
     $link_library = mysqli_connect("$manage_server","$user","$pw", "$database");
     if (mysqli_connect_errno())  {
          echo "Failed to connect to MySQL: $manage_server : $user : $pw :$database " . mysqli_connect_error();
     }

    $query = "select libraryname from libraries where library_id = $library_id";
    
     $library_result = mysqli_query($link_library, $query);
    
     $a_row = mysqli_fetch_array($library_result, MYSQLI_ASSOC);
     $libraryname = stripslashes($a_row['libraryname']);


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/animatebg.css" rel="stylesheet">
    <link href="css/category.css" rel="stylesheet">
</head>

<body>

    <div class="loader">
        <div class="progress">
            <div class="progress-bar progress-bar-striped"></div>
        </div>
    </div>

    <div class="animate-container">
        <div class="bird" id="bird1">
            <img src="./assets/img/bg/bird.gif"/>
        </div>
        <div class="bird" id="bird2">
            <img src="./assets/img/bg/bird.gif"/>
        </div>
        <!-- <div class="bird" id="bird3">
            <img src="./assets/img/bg/bird.gif"/>
        </div> -->
    
        <div id="balloon1" class="balloon"></div>
        <div id="balloon2" class="balloon"></div>
        <div id="balloon3" class="balloon"></div>
    </div>

    <div class="container-fluid vh-100 main">
        <div class="position-absolute cloudBg" id="cloud">
            <img src="assets/img/bg/cloud-2.png" alt="cloud-1" />
            <img src="assets/img/bg/cloud-2.png" alt="cloud-2" style="transform: translate(0, 100px);" />
            <img src="assets/img/bg/cloud-2.png" alt="cloud-1" />
            <img src="assets/img/bg/cloud-2.png" alt="cloud-2" style="transform: translate(0, 100px);"  />
            <img src="assets/img/bg/cloud-2.png" alt="cloud-1" />
        </div>
        <form class="search px-5 d-flex flex-row justify-content-center align-items-center" action="book_jacket.php" type="get">
            <input type="text" name="filterTerm" value="searchBox" hidden />
             <input type="text" name="library_id" value="<?php echo $library_id?>" hidden />
            <input type="text" class="form-control" name="searchBox" />
            <button type="submit" class="searchBtn mx-2">Search</button>
        </form>
        <div class="title rounded-4 px-3 d-flex align-items-center text-black">
            Explore Categories
        </div>
        <div class="content overflow-hidden" id="content">
            <div class="prevBtn" id="prev"></div>
            <div class="nextBtn" id="next"></div>
            <div id="container" class="position-relative w-100 h-100">

                <!-- I modified the code here -->
                <?php

                    foreach($result as $item) {
                        echo "<div class=\"custom-card d-flex justify-content-center align-align-items-center\" title=\"".$item['name']."\" data-id=\"".$item["name"]."\" data-library=\"".$library_id."\">".
                                "<img src=\"".$item['imgUrl']."\" draggable=\"false\" >".
                             "</div>";
                    };
                ?>
                <!-- ======================== -->

            </div>
        </div>
    </div>

    <div class="footer w-100">
        <div class="grass w-100" id="grass">
            <img src="assets/img/bg/grass-30.png" width="auto"/>
        </div>
        <a href="#" class="dogImg">
            <img src="assets/img/item/horse.png" alt="horse" />
        </a>
        <a href="#" class="dogHouse">
            <img src="assets/img/item/barn.png" alt="barn" />
        </a>
        <div class="footerContent rounded-4 d-flex justify-content-between px-4">
            <a class="d-flex flex-column text-decoration-none footer-item" href="category.php?library_id=<?php echo $library_id?>">
                <div class="imgBtn d-flex">
                    <div class="imgBtnItem item1 p-1">
                        <img src="./assets/img/categories/Money.png" class="w-100 h-100" />
                    </div>
                    <div class="imgBtnItem item2 p-1">
                        <img src="./assets/img/categories/Olympic.png" class="w-100 h-100" />
                    </div>
                    <div class="imgBtnItem item3 p-1">
                        <img src="./assets/img/categories/Horse.png" class="w-100 h-100" />
                    </div>
                    <div class="imgBtnItem item4 p-1">
                        <img src="./assets/img/categories/Airplane.png" class="w-100 h-100" />
                    </div>
                </div>
                <span>Explore Categories</span>
            </a>
            <a class="d-flex flex-column text-decoration-none footer-item" href="series.php?library_id=<?php echo $library_id?>">
                <div class="imgBtn d-flex">
                    <div class="imgBtnItem item1 p-1">
                        <img src="./assets/img/series/Captain Underpants.jpeg" class="w-100 h-100" />
                    </div>
                    <div class="imgBtnItem item2 p-1">
                        <img src="./assets/img/series/Diary of a Wimpy Kid.jpeg" class="w-100 h-100" />
                    </div>
                    <div class="imgBtnItem item3 p-1">
                        <img src="./assets/img/series/Mercy Watson.jpeg" class="w-100 h-100" />
                    </div>
                    <div class="imgBtnItem item4 p-1">
                        <img src="./assets/img/series/Harry Potter.jpeg" class="w-100 h-100" />
                    </div>
                </div>
                <span>Explore Series</span>
            </a>
        </div>
        <div class="footerBar w-100 d-flex overflow-visible">
            <a href="#" class="text-white text-decoration-none">Library Catalog</a>
            <a href="#" class="text-white text-decoration-none mx-3"></a>
            <div class="flex-grow-1"></div>
            <a href="#" class="text-white text-decoration-none address">
                <span class="a"><?php echo $libraryname?></span>
                <span class="b"></span>
                <span class="c"></span>
                <span class="d"></span>
            </a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="./js/script.js"></script>
    <script>
        initCards(140, 140, "category");
    </script>
    <script src="js/animatebg.js"></script>
    <script src="./js/loader.js"></script>
</body>

</html>
