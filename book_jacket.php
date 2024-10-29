
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
    
    # This is code for gettring search term and search content
    $term = isset($_GET['filterTerm']) ? $_GET['filterTerm'] : ""; 
    $search = $term ? $_GET[$term] : "";
    # You can use these values for mysql query to select corresponding filtered result
    

    $term = $search;
    
    # Let's assume that you got below result array by mysql query above.
    $result_array = [
        // [
        //     "id"     => "a",
        //     "title"  => "a",
        //     "status" => "in",
        //     "type"   => "book",
        //     "level"  => "99L",
        //     "imgUrl" => "a",
        //     "location" => "Juv Pict",
        //     "callnum" => "J Pict Burl 2011"
        // ],
        // [
        //     "id"     => "a",
        //     "title"  => "a",
        //     "status" => "in",
        //     "type"   => "book",
        //     "level"  => "99L",
        //     "imgUrl" => "a",
        //     "location" => "Juv Pict",
        //     "callnum" => "J Pict Burl 2011"
        // ],
        // [
        //     "id"     => "a",
        //     "title"  => "a",
        //     "status" => "in",
        //     "type"   => "book",
        //     "level"  => "99L",
        //     "imgUrl" => "a",
        //     "location" => "Juv Pict",
        //     "callnum" => "J Pict Burl 2011"
        // ],
        // [
        //     "id"     => "a",
        //     "title"  => "a",
        //     "status" => "in",
        //     "type"   => "book",
        //     "level"  => "99L",
        //     "imgUrl" => "a",
        //     "location" => "Juv Pict",
        //     "callnum" => "J Pict Burl 2011"
        // ],
    ];
        
        
        
    ########################################################
    # Modify code goes here. You can reference below code. #
    ########################################################
    
    require_once("/library/webserver/cgi-executables/kids_ini.php");
    include("functions.php");
    
    
    #############################################################################
    # Get the library name and other options from the library table     
    #############################################################################
    require_once("/library/webserver/cgi-executables/kids_ini.php");
    
     
    $database = "libraryworld";
    $link_library = mysqli_connect("$library_server","$user","$pw", "$database");
     if (mysqli_connect_errno())  {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $query = "select libraryname from libraries where library_id = $library_id";
    
    $library_result = mysqli_query($link_library, $query);
    
    $a_row = mysqli_fetch_array($library_result, MYSQLI_ASSOC);
    $libraryname = stripslashes($a_row['libraryname']);
    
    

    # Search for term using filter 


    $term = normalize_term($term);

    if (strlen($term) >= 2 ) {
        $database = "library_$library_id";
        $link = mysqli_connect("$library_server","$user","$pw", "$database");
         if (mysqli_connect_errno())  {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $words = explode(' ',$term);
        $union_findset = array();
        $count_loop = 0;

        foreach ($words as $word) {
            $count_loop++;
            $findset = array();
            $where_str = "index_key like 'CAT::$word%::$field_num%'";
            $query = "SELECT index_value from index_words where $where_str group by index_id";

            $result = mysqli_query($link, $query);
            
            $num_rows = mysqli_num_rows($result);
            if ($num_rows > 0) {
	            $old_id = '';			// used to deduplicate
	            while($a_row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		            $index_value = stripslashes($a_row['index_value']);
		            $fields = explode('::',$index_value);
		            $record_id = $fields[1];
		            if ($record_id != $old_id) {
			            array_push($findset,$record_id);
		            }
		            $old_id = $record_id;
	            }
            }
            if ($count_loop == 1) {
	            $union_findset = $findset;
            }
            else {
	            $union_findset = array_intersect($union_findset, $findset);
            }
        }
        $findset_count = count($union_findset);
        if ($findset_count >= 501) {
            $union_findset = '';
        }

        #create the carrousal
        foreach($union_findset as $record_id) {
	        
	        $query = "select catalog_id, cover_id, type, record, thumbnail from catalog where catalog_id = $record_id";
	        $result = mysqli_query($link, $query);
	        $a_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	        
	        $a_catalog_id = stripslashes($a_row['catalog_id']);
	        $a_cover_id = stripslashes($a_row['cover_id']);
	        $a_type = stripslashes($a_row['type']);
	        $a_record = stripslashes($a_row['record']);
	        $thumbnail = stripslashes($a_row['thumbnail']);
	        
	        $r_count = 10;
	        $a_record = str_replace('\'\'','\'',$a_record);
	        $a_record = str_replace('""','"',$a_record);
	        
	        $a_record = str_replace('\'\'','\'',$a_record);
	        $a_record = str_replace('""','"',$a_record);
	        
	        # $lib_call = '082';			//  needs to be updated to by dynamic.
	        $lib_call = $_SESSION['lib_call'];			// where is the call
	        $lib_subcall = $_SESSION['lib_subcall'];   // where is the subcall
	        
	        $cat_fields = getFields($a_record);
	        
	        $isbn = $cat_fields[0];
	        $issn = $cat_fields[1];
	        $author = $cat_fields[2];
	        $title = $cat_fields[3];
	        $call = $cat_fields[4];
	        $notes = $cat_fields[5];
	        $pub_date = $cat_fields[6];
	        $target_audience = $cat_fields[7];
	        $study_program_note = $cat_fields[8];
	        $electronic_access_field = $cat_fields[9];  // electronic access field

	        $notes = substr($notes,4);
	        
	        
	        # retrieve the first holdingrecord.
	        $query = "SELECT holding_id, barcode, branch, location, status, call_number, call_cutter, price, volume, issue from holdings where catalog_id = '$record_id'";


	        $result = mysqli_query($link, $query);
	        $a_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	        
	        $holding_id = stripslashes($a_row['holding_id']);
		    $barcode = stripslashes($a_row['barcode']);
		    $branch = stripslashes($a_row['branch']);
		    
		    $location = stripslashes($a_row['location']);
		    $status = stripslashes($a_row['status']);
		    $call_number = stripslashes($a_row['call_number']);
		    $call_cutter = stripslashes($a_row['call_cutter']);
		    $price = stripslashes($a_row['price']);
		    $volume = stripslashes($a_row['volume']);
		    $issue = stripslashes($a_row['issue']);

	        $status = strtolower($status);
	        
	        if ($status == 'hold') {
	            $status = 'out';
	        }
	        if ($status == 'lost') {
	            $status = 'out';
	        }
	        
	         $coverstr = "<img src=\"cover_server.php?cover_id=$a_cover_id&isbn=$isbn&type=$a_type\" height=$size border=0 alt=\"Book Jacket\">";
	        
            # update the array here.
            
            $result_array[] = [
                "id"     => "$a_catalog_id",
                "title"  => "$title",
                "status" => "$status",
                "type"   => "book",
                "level"  => "$target_audience",
                "imgUrl" => "cover_server.php?cover_id=$a_cover_id&isbn=$isbn&type=$a_type\" height=$size border=0 alt=\"Book Jacket\"",
                "location" => "$location",
                "callnum" => "$call_number $call_cutter"
            ];
        }
    }  # end if strlen great or equal to 2 . Do not want to search for 1 character or nothing. 
    
    # ##########################################################################################################################  

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
    <!-- <img src="./assets/img/item/loader-big.gif" alt="loader" id="loader" /> -->

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
            <input type="text" class="form-control" value="<?php if($term == "searchBox") echo $search; ?>" name="searchBox" />
            <button type="submit" class="searchBtn mx-2">Search</button>
        </form>
        <div class="title rounded-4 px-3 d-flex align-items-center text-black">


            <!-- Place the number of result here -->
            <span id="numResults">
                <?php echo count($result_array) ?>
            </span>


            <span style="margin: 0px 8px;">Results for</span>

            <!-- Place the name of category here -->
            <span id="catName">
                <?php echo $search ?>
            </span>

        </div>
        <div class="content overflow-hidden" id="content">
            <div class="prevBtn" id="prev"></div>
            <div class="nextBtn" id="next"></div>
            <div class="jacket-container slider" id="container">
                
                <!-- -------------------------------------------- -->
                <!--  This is for exporint the card item elements -->
                <!-- -------------------------------------------- -->
                    <?php
                        $colors = ["gray", "purple", "green"];
                        
                        foreach($result_array as $item) {
                            $randomNumber = random_int(0, 2);
                            echo "<div>".
                                    "<div data-id=\"".$item["id"]."\" data-default='".$colors[$randomNumber]."' class='jacket-card d-flex justify-content-center flex-column align-items-center position-relative'>".
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
                                        "<div class=\"fallback\">".$item["title"]."</div>".
                                        "<img src='".$item['imgUrl']."' onerror=\"this.src='assets/img/item/".$colors[$randomNumber].".png'; this.alt=''; this.nextElementSibling.style.display='block';\" onload=\"this.previousElementSibling.style.display='none';\" />".
                                        "<div class=\"alt-text\">".$item["title"]."</div>".
                                        "<div class=\"jacket-footer\">".
                                            "<span>".$item['location']."</span>".
                                            "<span>".$item['callnum']."</span>".
                                        "</div>".
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
                    <img src="" alt="cover_page_img" class="w-100" id="cover-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"  onload="this.style.display='block'; this.nextElementSibling.style.display='none';"/>
                    <div class="thumb-alt">
                        <img id="thumb-alt-img" src="" />
                        <span id="thumb-alt-text"></span>
                    </div>
                    <img src="" alt="availability" class="detail-avai" id="avail-img" />
                    <img src="" alt="type" class="detail-type" id="type-img" />
                </div>
                <button class="btn btn-style placehold">Change Hold</button>
                <div class="links d-flex flex-column align-items-end justify-content-end">
                    <a href="#" class="text-decoration-none kalam modal-link" data-to="copies-container">Copies</a>
                    <a href="#" class="text-decoration-none kalam modal-link" data-to="summary">Summary</a>
                    <a href="#" class="text-decoration-none kalam modal-link" data-to="levels-container">Reading Levels</a>
                    <a href="#" class="text-decoration-none kalam modal-link" data-to="details-container">Details</a>
                </div>
            </div>

            <div class="right-section d-flex flex-column overflow-auto flex-grow-1">
                <h1 class="large-text" id="title">Wolves</h1>
                <div id="copies-container">
                    <div class="bg-blue-heading kalam">Copies</div>
                    <div id="copies"></div>
                </div>
                <div id="summary"></div>
                <div class="d-flex flex-column" id="levels-container">
                    <div class="bg-blue-heading kalam">Reading Levels</div>
                    <div id="levels"></div>
                </div>
                <div class="d-flex flex-column" id="details-container">
                    <div class="bg-blue-heading kalam">Details</div>
                    <div id="details"></div>
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
                <label for="name">Name *</label>
                <input type="text" required name="name" id="name" class="form-control" />
            </div>
            <div class="login-item my-3">
                <label for="email">Email *</label>
                <input type="email" required name="email" id="email" class="form-control" />
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
        <!-- <div class="pageCat">
            <img src="assets/img/categories/on (1).png" id="pageCatImg" />
        </div> -->

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
                <span>Chapter & Series</span>
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

    <!-- Here, the JS script goes -->
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="./js/slick.js" type="text/javascript" charset="utf-8"></script>
    <script src="./js/jacket.js" type="text/javascript" charset="utf-8"></script>
    <script>
        initCardSizeOption();
        initSlick();
        initModalEffects();
    </script>
    <!-- <script src="js/loader.js"></script> -->

</body>

</html>
