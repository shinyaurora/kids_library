<?php



////////////////////  break out standard fields from a record, return as a tab del string  ///////////
function getFields($record) {

 	$sub_fieldseperator = "\x{1f}";			// seperates the subfields
	$isbn = ''; $issn = '';
	$title = ''; $author = ''; $call = ''; $notes = '';
	$subject = '';
	$mod_date = '';
	$authority = '';
	$pub_date = '';
	$description = '';

	$target_audience = '';
	$study_program_note = '';
	$subjects = '';
	$series;
	$electronic_access_field = '';
	$control = '';
	
	global $opac_surpress;
	
	// get the record 
	
	$lib_call = '082';			//  needs to be updated to by dynamic.
	$lib_call = $_SESSION['lib_call'];
	$lib_subcall = $_SESSION['lib_subcall'];
	
	$pos_856 = strpos($opac_surpress,'856');
	
	/////////  formate a briefline 
	$fields = explode("\n", $record);
	$leader = $fields[0];						// get the first field which should be the leader
	$rectype = substr($leader,11,2); 			// get record type from leader
	
	foreach ( $fields AS $field ) {
		$fieldtag = substr ( $field, 0, 3);
		
		if ($fieldtag === '001') {
			$control  = getValue($field,$fieldtag); 
		}
		
		if ($fieldtag === '020') {
			$isbn  = getValue($field,$fieldtag); 
		}
		if ($fieldtag === '100') {
			$author  = getValue($field,$fieldtag); 
		}
		if ($fieldtag === '245') {
			//$title  = getValue($field,$fieldtag); 
			
			$field_parts = explode("\t",$field);
			$field_data = $field_parts[2];
			$subfields = preg_split('/\x{1f}/',$field_data);
			foreach ($subfields as $subfield) {
				$sub_tag = substr($subfield,0,1);
				if ($sub_tag == 'a' || $sub_tag == 'b') {
					$title .= substr($subfield,1);
					$title .= ' ';
				}

				if ($sub_tag == 'c') {
					$title .= substr($subfield,1);
					$title .= ' ';
				}

				if ($sub_tag == 'n') {
					$title .= substr($subfield,1);
					$title .= ' ';
				}
				if ($sub_tag == 'p') {
					$title .= substr($subfield,1);
					$title .= ' ';
				}
			}	
		}
		if ($fieldtag === '260') {
			$field_parts = explode("\t",$field);
			$field_data = $field_parts[2];
			$subfields = preg_split('/\x{1f}/',$field_data);
			foreach ($subfields as $subfield) {
				$pub_date .= substr($subfield,1);
				$pub_date .= ' ';
			}
		}

		if ($fieldtag === '264') {
			$field_parts = explode("\t",$field);
			$field_data = $field_parts[2];
			$subfields = preg_split('/\x{1f}/',$field_data);
			$pub_date = '';
			foreach ($subfields as $subfield) {
				$pub_date .= substr($subfield,1);
				$pub_date .= ' ';
			}
		}
		
	    if ($fieldtag === '300') {		
	        $description  = getValue($field,$fieldtag); 					// series
		}
		
	     if ($fieldtag === '490') {		
	        $series  = getValue($field,$fieldtag); 					// series
		}

		if ($fieldtag === '500') {
			$field_parts = explode("\t",$field);
			$field_data = $field_parts[2];
			$subfields = preg_split('/\x{1f}/',$field_data);
			foreach ($subfields as $subfield) {
				$notes .= '<br><br>';
				$notes .= substr($subfield,1);
				$notes .= ' ';
			}
		}

		if ($fieldtag === '520') {
			$field_parts = explode("\t",$field);
			$field_data = $field_parts[2];
			$subfields = preg_split('/\x{1f}/',$field_data);
			foreach ($subfields as $subfield) {
				$notes .= '<br><br>';
				$notes .= substr($subfield,1);
				$notes .= ' ';
			}
		}
		if ($fieldtag === '521') {							// target audience
			$field_parts = explode("\t",$field);
			$field_data = $field_parts[2];
			$subfields = preg_split('/\x{1f}/',$field_data);
			foreach ($subfields as $subfield) {
				$target_audience .= substr($subfield,1);
				$target_audience .= ' ';
			}
		}
		if ($fieldtag === '526') {							// study program note
			$field_parts = explode("\t",$field);
			$field_data = $field_parts[2];
			$subfields = preg_split('/\x{1f}/',$field_data);
			foreach ($subfields as $subfield) {
				$study_program_note .= substr($subfield,1);
				$study_program_note .= ' ';
			}
		}
		
	    if ($fieldtag === '650') {		
	        $subject  = getValue($field,$fieldtag); 					// study program note
	        $subjects .= "$subject,";

		}
		
		
		if ($fieldtag === '856' && $pos_856 === false) {							// electronic location and access field
			$url = '';
			$linkName = '';
			$hostname = '';
			$public_note = '';
			
			$field_parts = explode("\t",$field);
			$field_data = $field_parts[2];
			$subfields = preg_split('/\x{1f}/',$field_data);
			
			foreach ($subfields as $subfield) {
				$sub_tag = substr($subfield,0,1);
				$sub_data = substr($subfield,1);
				if ($sub_tag == 'u') {
					$url = $sub_data;
				}
				if ($sub_tag == 'y') {
					$linkName = $sub_data;
				}
				if ($sub_tag == 'a') {
					$hostname = $sub_data;
				}
				if ($sub_tag == 'z') {
					$public_note = $sub_data;
				}
			}
			if ($url) {
				$link_source = '/images/link_doc.jpg    width=42';
				
				if ($linkName == '') {
					$linkName = $url;
				}
				
				$pos = strpos($url,'.pdf');
				if($pos > 0) {
					$link_source = '/images/pdf.jpg     width=42 ';
				}
				
				$pos = strpos($url,'.jpg');
				if($pos > 0) {
					$link_source= "$url   width=124 ";
				}
				$pos = strpos($url,'.tif');
				if($pos > 0) {
					$link_source= "$url   width=124 ";
				}
				$pos = strpos($url,'.jpeg');
				if($pos > 0) {
					$link_source= "$url   width=124 ";
				}
				
				$electronic_access_field .=  "<table width=100% border=0><tr>
				<td valign=top  width=128\"><a href=\"$url\" target=\"_blank\"><img src=$link_source border=0 valign=bottom title=\"$linkName\"><a></td>
				<td valign=top\"><a href=\"$url\" target=\"_blank\">$linkName</a>
				<br>
				$hostname<br>
				$public_note
				</td>
				</tr></table>";
			}
		}
		
		if ($fieldtag === $lib_call) {
			$field_parts = explode("\t",$field);
			$field_data = $field_parts[2];
			$subfields = preg_split('/\x{1f}/',$field_data);
			foreach ($subfields as $subfield) {
				$subtag = substr($subfield,0,1);  // get the actual subtag
				# if subutage is within lib_subcall then it is true and continues, else false and skips
				$value = strpos("$lib_subcall","$subtag");
				if ($value === false) {		// do nothing
					$call .= '';
				}
				else {						// add to call number
					$call .= substr($subfield,1);
					$call .= ' ';
				}
			}
		}
		
	}
	
	$fields = array($isbn,$issn,$author,$title,$call,$notes,$pub_date, $target_audience, $study_program_note, $electronic_access_field, $control, $subjects, $series, $description);
	return $fields;
}


////////////////////  function to split out a subfield using special subfield seperator ///////////
function getValue($field, $tag) {
    $sub_fieldseperator = "\x{1f}";
    $parts = explode("\t", $field);
    $fielddata = $parts[2];
    //$subfields = preg_split("$sub_fieldseperator",$fielddata);
    $subfields = preg_split('/\x{1f}/',$fielddata);
    
    if ($tag === "260") {  # get the year!
    	$year = '';
		foreach ($subfields as $subfield) {
			if (substr($subfield,0,1) == 'c') {
				$subfield = preg_replace("/[^0-9]/", "", $subfield);
				$year = substr($subfield,0,4);
			}
		}
		return $year;
	}

	if ($tag === "264") {  # get the RDA year!
    	$year = '';
		foreach ($subfields as $subfield) {
			if (substr($subfield,0,1) == 'c') {
				$subfield = preg_replace("/[^0-9]/", "", $subfield);
				$year = substr($subfield,0,4);
			}
		}
		return $year;
	}
    
    if ($subfields[0] ) {
	if ($tag === "005" || $tag == '001') {
	    return substr($subfields[0], 0);	    
	} else {
		$field = substr($subfields[0], 1);
		///$field = strtoupper($field);
	    return $field;
	}

    } else {
	return "*"; # for some reason no data available. Return something.
   }
}
// end of getValue function


////////////////////  Sort a find set place back in appropriate file  ///////////
function sortFindset($sortfield,$module) {
	//  read contents of finset file into an array
	$library_id = $GLOBALS['library_id'];
	$manage_server = $GLOBALS['manage_server'];
	$library_server = $GLOBALS['library_server'];
	$user = $GLOBALS['user'];
	$pw =  $GLOBALS['pw'];
	$username =  $GLOBALS['username'];
	
	$record_types = $_SESSION['record_types'];
	if ($record_types == '') {
		$record_types = 'All Types';
	}
	
	$myFile = "/data/findsets/$library_id-$username";
	
	if ($module === 'standard' ) {
		$myFile = "/data/findsets/$library_id-$username";
	}
	if ($module === 'simple' ) {
		$myFile = "/data/findsets/simple_$username";
	}
	elseif ($module === 'advanced') {
		$myFile = "/data/findsets/adv_$username";
	}
	elseif ($module === 'clipboard') {
		$myFile = "/data/clipboards/$username";
	}
	elseif ($module === 'browse') {
		$myFile = "/data/findsets/browse_$username";
	}
	elseif ($module === 'union_standard') {			// special dynamic library
		
		$library_id = $_SESSION['u_library_id'];
		$library_server = $_SESSION['u_server'];
		$libraryname = $_SESSION['u_libraryname'];
		
		$myFile = "/data/findsets/$library_id-$username";
	}
	

	
	
    $database = "library_$library_id";
    $link = mysqli_connect("$library_server","$user","$pw", "$database");
     if (mysqli_connect_errno())  {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    

	$contents = '';
	$find_count = 0;
	$record_ids;
	$filename = $myFile;
	if (file_exists($filename)) {
		$contents = file_get_contents($filename);
		$contents = chop($contents,"\n");		// remove trailing carriage return
		$record_ids = explode("\n",$contents);
		$find_count = count($record_ids);
	}
	
	$sort_array = array();
	
	$sleep_count = 0;
	
	foreach ($record_ids as $record_id) {
		
		$sleep_count++;				# slow sorting up!
		if ($sleep_count >= 200) {
			sleep(1);
			$sleep_count = 0;
		}
		
		$rec_fields = explode('::',$record_id);
		$record_id = $rec_fields[0];		// remove any additional information 
		
		$query = "select catalog_id, cover_id, type, record from catalog where catalog_id = $record_id";
        $result = mysqli_query($link, $query);
        $a_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$a_catalog_id = stripslashes($a_row['catalog_id']);
		$a_cover_id = stripslashes($a_row['cover_id']);
		$a_type = stripslashes($a_row['type']);
		$a_record = stripslashes($a_row['record']);
		
		$title = ''; $author = ''; $call = ''; $year = '';
		
		$lib_call = $_SESSION['lib_call'];
		
		# record tyep filter
		if ($record_types != 'All Types') {
			$r_type = get_type($record_types);			#get type?.. 
			if ($a_type != $r_type) {		# this should skip it
				continue;
			}
		}
	
		
		/////////  formate a briefline 
		$fields = explode("\n", $a_record);
		$leader = $fields[0];						// get the first field which should be the leader
		$rectype = substr($leader,11,2); 			// get record type from leader
		
		foreach ( $fields AS $field ) {
			$fieldtag = substr ( $field, 0, 3);
			if ($fieldtag === '100') {
				$author  = getValue($field,$fieldtag); 
			}
			if ($fieldtag === '245') {
				$title  = getValue($field,$fieldtag); 
				$title =  strtolower($title) ;


				if (strpos($title, 'the ') === 0) {
				    $title = substr($title, 4);
				}
				if (strpos($title, 'a ') === 0) {
				    $title = substr($title, 2);
				}
				if (strpos($title, 'an ') === 0) {
				    $title = substr($title, 3);
				}
	
			}
			if ($fieldtag === '260') {
				$year  = getValue($field,$fieldtag); 	
			}
			if ($fieldtag === '264') {  #new RDA Standard
				$year  = getValue($field,$fieldtag); 	
			}
			if ($fieldtag === $lib_call ) {
				$call  = getValue($field,$fieldtag); 	
			}
		}
		
		// sort holdings..call numbers
		if ($lib_call == '') {

			$query2 = "select call_number, call_cutter from holdings where catalog_id = $record_id ";
            $result2 = mysqli_query($link, $query2);
            $a_row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
			
			$call = stripslashes($a_row2['call_number']);
			$sub_call = stripslashes($a_row2['call_cutter']);
			$call = $call . ' ' . $sub_call;
		}
		
		$sortfield = strtolower($sortfield);
		
		if ($sortfield === 'title') {
			$t_record = "$title" . "\t" . "$record_id";
			array_push($sort_array, $t_record);
		}
		elseif ($sortfield === 'author') {
			$t_record = "$author" . "\t" . "$record_id";
			array_push($sort_array, $t_record);
		}
		elseif ($sortfield === 'call') {
			$t_record = "$call" . "\t" . "$record_id";
			array_push($sort_array, $t_record);
		}	
		elseif ($sortfield === 'newest first') {
			$t_record = "$year" . "\t" . "$record_id";
			array_push($sort_array, $t_record);
		}
		elseif ($sortfield === 'oldest first') {
			$t_record = "$year" . "\t" . "$record_id";
			array_push($sort_array, $t_record);
		}
	}
	if ($sortfield === 'newest first' || $sortfield === 'oldest first') {
		if ($sortfield === 'year') {
			arsort($sort_array);
		}
		elseif ($sortfield === 'newest first') {
			arsort($sort_array);
		}
		elseif ($sortfield === 'oldest first') {
			asort($sort_array);
		}
		
	}
	else {
		sort($sort_array);	
	}
	$fh = fopen($myFile, 'w');
	
	foreach ($sort_array AS $record) {
		$r_fields = explode("\t", $record);
		$record_id = $r_fields[1];
		fwrite($fh, "$record_id\n");
	}
	fclose($fh);
	mysqli_close($link);
	return;
}

function get_type($record_types) {
	$record_types = strtoupper($record_types);
	$type_hash = array(
			"BOOKS"=>"am",
			"SERIALS"=>"as",
			"MAPS"=>"em",
			"VISUAL MATERIALS"=>"gm",
			"MUSIC SCORES"=>"cm",
			"NON-MUSIC SOUND RECORDINGS"=>"im",
			"MUSIC SOUND RECORDINGS"=>"jm",
			"COMPUTER FILES"=>"mm",
			"MANUSCRIPTS"=>"tm",
			"MIXED MATERIALS"=>"pm",
			"REALIA"=>"rm",
			"OTHER"=>"ot",					# other!.. not a real record type
			"AM"=>"am",
			"AS"=>"as",
			"EM"=>"em",
			"GM"=>"gm",
			"CM"=>"cm",
			"IM"=>"im",
			"JM"=>"jm",
			"MM"=>"mm",  
			"TM"=>"tm",
			"PM"=>"pm",
			"RM"=>"rm",
			"OT"=>"ot",
			);
			
	$r_type = $type_hash[$record_types];

	return $r_type;
}

////////////////////  Sort a find set place back in appropriate file  ///////////
function relevanceSort($sortfield,$module,$term, $orig_term) {
	//  read contents of finset file into an array
	$library_id = $GLOBALS['library_id'];
	$manage_server = $GLOBALS['manage_server'];
	$library_server = $GLOBALS['library_server'];
	$user = $GLOBALS['user'];
	$pw =  $GLOBALS['pw'];
	$username =  $GLOBALS['username'];
	
	$myFile = "/data/findsets/$library_id-$username";
	
	if ($module === 'standard' ) {
		$myFile = "/data/findsets/$library_id-$username";
	}
	if ($module === 'simple' ) {
		$myFile = "/data/findsets/simple_$username";
	}
	elseif ($module === 'advanced') {
		$myFile = "/data/findsets/adv_$username";
	}
	elseif ($module === 'clipboard') {
		$myFile = "/data/clipboards/$username";
	}
	elseif ($module === 'union_standard') {			// special dynamic library
		
		$library_id = $_SESSION['u_library_id'];
		$library_server = $_SESSION['u_server'];
		$libraryname = $_SESSION['u_libraryname'];
		
		$myFile = "/data/findsets/$library_id-$username";
	}
	
	
	
    $database = "library_$library_id";
    $link = mysqli_connect("$library_server","$user","$pw", "$database");
     if (mysqli_connect_errno())  {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
	
	

	$contents = '';
	$find_count = 0;
	$record_ids;
	$filename = $myFile;
	if (file_exists($filename)) {
		$contents = file_get_contents($filename);
		$contents = chop($contents,"\n");		// remove trailing carriage return
		$record_ids = explode("\n",$contents);
		$find_count = count($record_ids);
	}
	
	$sort_array = array();
	
	$sleep_count = 0;
	
	foreach ($record_ids as $record_id) {
		
		$sleep_count++;				# slow sorting up!
		if ($sleep_count >= 200) {
			sleep(1);
			$sleep_count = 0;
		}
		
		$rec_fields = explode('::',$record_id);
		$record_id = $rec_fields[0];		// remove any additional information 
	
		$query = "select catalog_id, cover_id, type, record from catalog where catalog_id = $record_id";
        $result = mysqli_query($link, $query);
        
        $a_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		

		$a_catalog_id = stripslashes($a_row['catalog_id']);
		$a_cover_id = stripslashes($a_row['cover_id']);
		$a_type = stripslashes($a_row['type']);
		$a_record = stripslashes($a_row['record']);
		
		$title = ''; $author = ''; $call = ''; $year = '';
		
		$lib_call = $_SESSION['lib_call'];
		
		/////////  formate a briefline 
		$fields = explode("\n", $a_record);
		$leader = $fields[0];						// get the first field which should be the leader
		$rectype = substr($leader,11,2); 			// get record type from leader
		
		$rel_counter = 0;  # counter for relevance sorting
		
		
		# first does the record have the search term as a string in it?  
		# if so give it a point
		$pos = stripos($a_record, $orig_term);
		// Note our use of ===.  Simply == would not work as expected
		// because the position of 'a' was the 0th (first) character.
		if ($pos === false) {
			$rel_counter = $rel_counter;
		} else {
			$rel_counter = $rel_counter + 1;			# found the exact term so give it a point.
		}
		
		
		foreach ( $fields AS $field ) {
			$fieldtag = substr ( $field, 0, 3);
			if ($fieldtag === '100') {
			
				$pos = stripos($field, $orig_term);
				if ($pos === false) {
					$rel_counter = $rel_counter;
				} else {
					$rel_counter = $re_counter + 30;			# found the fount it in author so give it a point
				}
				
			}
			if ($fieldtag === '245') {
				$pos = stripos($field, $orig_term);
				if ($pos === false) {
					$rel_counter = $rel_counter;
				} else {
					$rel_counter = $rel_counter + 20;			# found the fount it in title so give it a point
				}	
			}
			
			if ($fieldtag === '600') {	
				$pos = stripos($field, $orig_term);
				if ($pos === false) {
					$rel_counter = $rel_counter;
				} else {
					$rel_counter++;			# found the fount it in title so give it a point
				}			
			}
			
			if ($fieldtag === '610') {	
				$pos = stripos($field, $orig_term);
				if ($pos === false) {
					$rel_counter = $rel_counter;
				} else {
					$rel_counter++;			# found the fount it in title so give it a point
				}			
			}
			
			if ($fieldtag === '650') {	
				$pos = stripos($field, $orig_term);
				if ($pos === false) {
					$rel_counter = $rel_counter;
				} else {
					$rel_counter++;			# found the fount it in title so give it a point
				}			
			}
			
			
			
		}
		
		$rel_counter = str_pad((int) $rel_counter,4,"0",STR_PAD_LEFT);
		
		$t_record = "$rel_counter" . "\t" . "$record_id";
		array_push($sort_array, $t_record);
		
	}
	
	arsort($sort_array);

	$fh = fopen($myFile, 'w');
	foreach ($sort_array AS $record) {
		$r_fields = explode("\t", $record);
		$record_id = $r_fields[1];
		fwrite($fh, "$record_id\n");
	}
	fclose($fh);
	mysqli_close($link);
	return;
}





////////////////////  Sort union find set  ///////////
function sortClipboard($sortfield) {
	//  read contents of finset file into an array
	$library_id = $GLOBALS['library_id'];
	$manage_server = $GLOBALS['manage_server'];
	$library_server = $GLOBALS['library_server'];
	$user = $GLOBALS['user'];
	$pw =  $GLOBALS['pw'];
	$username =  $GLOBALS['username'];
	
	$myFile = "/data/clipboards/$username";

	$contents = '';
	$find_count = 0;
	$record_ids;
	$filename = $myFile;
	if (file_exists($filename)) {
		$contents = file_get_contents($filename);
		$contents = chop($contents,"\n");		// remove trailing carriage return
		$record_ids = explode("\n",$contents);
		$find_count = count($record_ids);
	}
	
	$sort_array = array();
	
	foreach ($record_ids as $record_id) {
		$full_record = $record_id;
		
		$rec_fields = explode('::',$record_id);
		$record_id = $rec_fields[0];		// remove any additional information 
		
		$c_library_id = $rec_fields[1];
		$c_library_server = $rec_fields[2];
		$c_library_name = $rec_fields[3];
		
		$link = mysql_connect("$c_library_server","$user","$pw");
		if (! $link) {  die("Could not connect to mysql"); }
		// select a database 
		$database = "library_$c_library_id";
		mysql_select_db($database, $link) or die ("Couldn't open manage database.");
		
		
		
		$query = "select catalog_id, cover_id, type, record from catalog where catalog_id = $record_id";
		$result = mysql_query( $query); 
		$a_row = mysql_fetch_array($result);
		$a_catalog_id = stripslashes($a_row['catalog_id']);
		$a_cover_id = stripslashes($a_row['cover_id']);
		$a_type = stripslashes($a_row['type']);
		$a_record = stripslashes($a_row['record']);
		
		$title = ''; $author = ''; $call = '';
		
		$lib_call = '082';			//  needs to be updated to by dynamic.
		$lib_call = $_SESSION['lib_call'];
		
		mysql_close($link);
		
		/////////  formate a briefline 
		$fields = explode("\n", $a_record);
		$leader = $fields[0];						// get the first field which should be the leader
		$rectype = substr($leader,11,2); 			// get record type from leader
		
		foreach ( $fields AS $field ) {
			$fieldtag = substr ( $field, 0, 3);
			if ($fieldtag === '100') {
				$author  = getValue($field,$fieldtag); 
			}
			if ($fieldtag === '245') {
				$title  = getValue($field,$fieldtag); 
			}
			if ($fieldtag === $lib_call ) {
				$call  = getValue($field,$fieldtag); 	
			}
		}
		
		if ($sortfield === 'title') {
			$t_record = "$title" . "\t" . "$full_record";
			array_push($sort_array, $t_record);
		}
		elseif ($sortfield === 'author') {
			$t_record = "$author" . "\t" . "$full_record";
			array_push($sort_array, $t_record);
		}
		elseif ($sortfield === 'call') {
			$t_record = "$call" . "\t" . "$full_record";
			array_push($sort_array, $t_record);
		}	
	}

	sort($sort_array);	
	
	$fh = fopen($myFile, 'w');
	
	foreach ($sort_array AS $record) {
		$r_fields = explode("\t", $record);
		$record_id = $r_fields[1];
		fwrite($fh, "$record_id\n");
	}
	fclose($fh);

	return;
}


//  set the index field number
function getIndex_Num($index_name) {
	$field_num = '';
	if ($index_name === 'Title') { 
		$field_num = '24'; 
	}
	elseif ($index_name === 'Author') {
		$field_num = '1';  // search all main entry fields
	}
	elseif ($index_name === 'Subject') {
		$field_num = '6';
	}

	elseif ($index_name === 'ISBN' ) {
		$field_num = '020a';
	}
	elseif ($index_name === 'ISSN' ) {
		$field_num = '020a';
	}
	elseif ($index_name === 'Target Audience') {
		$field_num = '521a';
	}
	
	elseif ($index_name === 'Study Program') {
		$field_num = '526';
	}
	elseif ($index_name === 'Reading Level') {
		$field_num = '526c';
	}
	elseif ($index_name === 'Series Title') {
		$field_num = '4';
	}
	elseif ($index_name === 'Barcode') {
		$field_num = 'Barcode';
	}
	elseif ($index_name === 'Call Number') {  //enhance this!.. with options
		$field_num = 'Call Number';
	}
	elseif ($index_name === 'Location') {
		$field_num = 'Location';
	}
	elseif ($index_name === 'Branch') {
		$field_num = 'Branch';
	}

	return($field_num);
}

////////////////////  strip stop words from string  ///////////
function normalize_term($term) {
	
	$term = trim($term);
	$term = str_replace('*', '%', $term);
	$term = str_replace('.', '', $term); 
	$term = str_replace(',', '', $term); 
	$term = str_replace(';', '', $term); 
	$term = str_replace('\'', '', $term); 
	$term = str_replace('-', '', $term);
	$term = str_replace('/', '', $term);

	$stopwords = array (			
		'a' => '1', 'about' => '1', 'an' => '1', 'are' => '1', 'as' => '1', 'at' => '1', 'be' => '1',
		'by' => '1', 'com' => '1', 'de' => '1', 'en' => '1', 'for' => '1', 'from' => '1',
		'how' => '1', 'in' => '1', 'is' => '1', 'it' => '1', 'la' => '1', 'not' => '1', 'of' => '1',
		'on' => '1', 'or' => '1', 'that' => '1', 'the' => '1', 'this' => '1', 'to' => '1',
		'what' => '1', 'when' => '1', 'where' => '1', 'will' => '1',
		'with' => '1', 'und' => '1', 'the' => '1', 'www' => '1',
	);
	
	$new_term = '';
	$words = explode(' ',$term);
	
	foreach($words AS $word) {
		if( $stopwords{strtolower($word)} == '1') {		# if its a stop word.. just skip over
			continue;
		}
		
		if (strlen($word) < 1 ) {				// prevents searching for nothing use to be < 2 for skipping one word terms.
		 continue;								//  changed it to make it more consisent with Manage Perl.
		}
		
		$new_term .= "$word ";	
	}
	
	$term = trim($new_term);
	
	// echo "<hr>$term<hr>";
	return $term;
	
	
}
// end of getValue function



############################################################################
# A translation of MARC formats for LDR column 6 and 7 to english.
function recordType($type) {

   $types = array( 
		"am" => "Book",
		"as" => "Serial",
		"cm" => "Music Score",
		"em" => "Maps",
		"gm" => "Visual Material",
		"im" => "Non-Music Sound Recording",
		"jm" => "Music Sound Recording",
		"mm" => "Computer File",
		"pm" => "Mixed Material",
		"tm" => "Manuscript",
		"rm" => "Realia",
		);

    $rtn = $types[$type];
    
    if ($rtn == '') {
    	$rtn = $type;
    }
    return $rtn;
}



?>
