<?php
    $requestUri = $_SERVER['REQUEST_URI'];

    if (strpos($requestUri, 'category') !== false) { // If it is the category page, then ...
        $term = "category";
    } else {    // If it is the series page, then ...
        $term = "series";
    }

    $result = [];

    $file = fopen("data/".$term.".txt", "r"); // Open the file in read mode
    if ($file) {
        // Loop through the file until the end
        while (($line = fgets($file)) !== false) {
            $arr = explode("\\r", $line);
            $arr = explode("\\t", $arr[0]);
            $name = $arr[0];
            $imgUrl = $arr[1];

            // Here will be the code part which checks whether the category or series has records or not
            if( true ) {// if it has at least one
                $result[] = [
                    "name" => $name,
                    "imgUrl" => $imgUrl
                ];
            }
        }

        fclose($file); // Close the file after reading
    }
?>  