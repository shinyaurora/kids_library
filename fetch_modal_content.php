<?php

    require_once("/library/webserver/cgi-executables/kids_ini.php");
    include("functions.php");

    $jacketID = isset($_POST['id']) ? $_POST['id'] : "";
    
    
    
    $database = "libraryworld";
    $link_library = mysqli_connect("$library_server","$user","$pw", "$database");
     if (mysqli_connect_errno())  {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $query = "select libraryname from libraries where library_id = $library_id";
    
    $library_result = mysqli_query($link_library, $query);
    
    $a_row = mysqli_fetch_array($library_result, MYSQLI_ASSOC);
    $libraryname = stripslashes($a_row['libraryname']);
    
    

    // Your MySQL Query and Fetch PHP Code Goes Here
    $record_id = $jacketID;
    
    $database = "library_$library_id";
    $link = mysqli_connect("$library_server","$user","$pw", "$database");
     if (mysqli_connect_errno())  {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
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
    $subjects = $cat_fields[11];
    $series = $cat_fields[12];
    $description = $cat_fields[13];

    $notes = substr($notes,4);
    
    # create subject array
    $relates = explode(",", $subjects);
    
    # #######################################################33
    # lets get the copy information
    # Each catalog record can have none or one or more copy records. 
    # I usually 
    
    $query = "SELECT holding_id, barcode, branch, location, status, call_number, call_cutter, price, volume, issue from holdings where catalog_id = '$record_id' order by pub_date, barcode";

    $result = mysqli_query($link, $query);
    
    
    # this is normally in a While statement to get all copies. 
    #  would like to inser each into the detail collections array below. 
            
    $collections = [];
        
    while($a_row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
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
        
        $total++;
        if ($status === 'IN') {
            $in_count++;
        }
        if ($status === 'HOLD') {
            $hold_count++;
        }
        if ($status == '') {
            $status = '[Empty]';
        }
        $status = strtolower($status);

        $collections[] = [
            "$location",
            "$call_number $call_cutter",
            "$status",
        ];
    }

    # ok there is more than one copy per title.  How to add more collections? 
    
    // After You Fetch Detailed Information, The Shape of That Info Should Be Like Below One
    
    $detail = [
        "coverImgUrl" => "cover_server.php?cover_id=$a_cover_id&isbn=$isbn&type=$a_type", // 
        "status" => "$status", // in or out
        "type" => "book", // book or dvd
        "title" => "$title", // title of jacket
        "copies" => [
            [
                "position" => "$libraryname",
                "collections" => $collections
            ],
            // More copies
        ],
        "summary" => [
            "$notes"
        ],
        "levels" => [
            "$target_audience", // Lexile Measure
            "$study_program_note", // AR Reading Level
            "MG", // AR Interest Level
            "0.5" // AR Points
        ],
        "details" => [
            "author" => [ // It's by ...
                "$author",
                // Some other authors
            ],
            "belongs" => [  // It's part of the series
                "$series"
                // Some other belongs
            ],
            "length" => "$description",
            "relates" => [
                "$relates[0]",
                "$relates[1]",
                "$relates[2]",
                "$relates[3]",
                "$relates[4]",
                "$relates[5]",
                "$relates[6]",
                "$relates[7]",
                "$relates[8]"

                // Some other related things
            ]
        ]
    ];
    
   

    $jsonDetail = json_encode($detail);
    echo $jsonDetail;
?>
