<?php												// Save settings of the user
require_once("/library/webserver/cgi-executables/kids_ini.php");

$cover_id = $_GET['cover_id'];
$type = $_GET['type'];
$isbn = $_GET['isbn'];

if ($type == '') {
	$type = 'am';
}

if ($cover_id == 1) {  # user forced cleared the cover
	$image = file_get_contents("images/$type.jpg");
	echo $image;
    return;
}



$database = 'covers';
$link = mysqli_connect("$cover_server","$user","$pw", "$database");
 if (mysqli_connect_errno())  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}




$image = '';
// Do the select the data from the users table

if ($cover_id >= 5) {
    $result = mysqli_query($link, "select image from covers where cover_id='$cover_id'");
	$a_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$image = $a_row['image'];
}
else {
	$isbn = str_replace('-','',$isbn);
	
	$fields = explode(' ',$isbn);
	$isbn = $fields[0];
	
	$nine_seven_eight = substr($isbn,0,3);
	if ($nine_seven_eight === '978') {
		$isbn = substr($isbn,3);
	}
	
	if (strlen($isbn) >= 9) {
		$result = mysqli_query($link, "select image, length(image) as size from covers where isbn='$isbn' order by size DESC");
	    $a_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$image = $a_row['image'];
	}
}

mysqli_close($link);	// close the link

if ($image) {
	// set the header for the image
	header("Content-type: image/jpeg");
	echo $image;
}
else {
	$image = file_get_contents("assets/img/$type.jpg");
	echo $image;
}


?>
