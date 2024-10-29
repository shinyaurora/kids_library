<?php

    $name = isset($_POST['name']) ? $_POST['name'] : "";
    $email = isset($_POST['name']) ? $_POST['email'] : "";
    $record_id = isset($_POST['name']) ? $_POST['record_id'] : "";
    $remember = isset($_POST['name']) ? $_POST['remember'] : "";
    
    if ($name == '') {
        exit;
    }
    if ($email == '') {
        exit;
    }

    // You can use these values to send email.


    date_default_timezone_set('America/Los_Angeles');

	require_once("/library/webserver/cgi-executables/kids_ini.php");
	include("functions.php");
	
	
	$database = "libraryworld";
    $link = mysqli_connect("$library_server","$user","$pw", "$database");
     if (mysqli_connect_errno())  {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
	
	$query = "select libraryname, hold_request_email from libraries where library_id = $library_id";
    
    $result = mysqli_query($link, $query);
    
    $a_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $libraryname = stripslashes($a_row['libraryname']);
    $hold_request_email = stripslashes($a_row['hold_request_email']);


    $database = "library_$library_id";
    $link = mysqli_connect("$library_server","$user","$pw", "$database");
     if (mysqli_connect_errno())  {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    # get library name and hold_request_email
	
	
    $query = "select cover_id, type, record from catalog where catalog_id = $record_id";
    $result = mysqli_query($link, $query);
    
    $a_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	
	$cover_id = stripslashes($a_row['cover_id']);
	$type = stripslashes($a_row['type']);
	$record = stripslashes($a_row['record']);
	if ($_SESSION['record'] != '') {
		$record = $_SESSION['record'];
	}
	$type = substr($record,11,2); 			// get record type from leader
	
	$record = str_replace('""','"',$record);
	
	$cat_fields = getFields($record);
	
	$isbn = $cat_fields[0];
	$author = $cat_fields[2];
	$title = $cat_fields[3];
	$call = $cat_fields[4];
	
	//  get call if still lib_call is blank

    $query2 = "select call_number, call_cutter from holdings where catalog_id = $catalog_id ";
    $result2 = mysqli_query($link, $query2);
    $a_row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
	
	
	
	$a_call = stripslashes($a_row2['call_number']);
	$a_sub_call = stripslashes($a_row2['call_cutter']);
	$a_call = $a_call . ' ' . $a_sub_call;
	
	if ($a_call != '') {
		$call = $a_call;
	}

	
	/////////  formate a title with type 
	$fields = explode("\n", $record);
	$leader = $fields[0];						// get the first field which should be the leader
	$rectype = substr($leader,11,2); 			// get record type from leader
	
	$titlestr = "$title ($type) ";
	
	$to = "$hold_request_email";
	$from_email = 'noreply@libraryworld.com';
	$subject = "LibraryWorld Hold Request";
	$msg = "This is a hold request for an item in the library $libraryname\n\n";
      
    $msg .= "Title: $title\n\n";
    $msg .= "Call Number: $call\n\n";
   	 $msg .= "Author: $author\n\n";

   	 $msg .= "Please hold or reserve the above item for the following person:\n\n";
   	 
   	 $msg .= "Name: $name\n\n";
   	 $msg .= "Patron Email: $email\n\n";

     $msg = str_replace("'","",$msg);
     $msg = str_replace('"','',$msg);
        
	 $rtn = system("perl /usr/lib/cgi-bin/sendgrid.pl '$to' '$from_email' '$subject' '$msg'"); 



?>
