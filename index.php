<?php

    require_once("/library/webserver/cgi-executables/kids_ini.php");
    date_default_timezone_set('America/Los_Angeles');

    $URL = explode("/",$_SERVER['QUERY_STRING']);

    $libraryname = $URL[0];
    
    $libraryname = str_replace("-"," ",$libraryname);

   
    session_name( 'kids' );
    session_start();
    
     $database = "libraryworld";
     $link_library = mysqli_connect("$manage_server","$user","$pw", "$database");
     if (mysqli_connect_errno())  {
          echo "Failed to connect to MySQL: $manage_server : $user : $pw :$database " . mysqli_connect_error();
     }

     $query = "select library_id, opac_pw, security from libraries where libraryname= '$libraryname' ";
   
    
     $library_result = mysqli_query($link_library, $query);
    
     $a_row = mysqli_fetch_array($library_result, MYSQLI_ASSOC);
     
     $library_id = stripslashes($a_row['library_id']);
     
     $opac_pw = stripslashes($a_row['opac_pw']);
     
     $opac_pw = stripslashes($a_row['opac_pw']);
     
     
     if ($library_id == '') {
         header("location:https://opac.libraryworld.com");
         exit;
     }
     
     # kids willnot work if there is a password
     if ($opac_pw != '')  {
         header("location:https://opac.libraryworld.com");
         exit;
     }
     
     # kids willnot work if there if IP security is turned on
     if ($security != '')  {
         header("location:https://opac.libraryworld.com");
         exit;
     }
     
     header("location:/kids/category.php?library_id=$library_id");
     
   
    exit;
?>
