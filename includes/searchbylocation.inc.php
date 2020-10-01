<?php

if (isset($_GET['location'])) {

    //session_start();

    include 'dbh.inc.php';
    include 'functions.inc.php';

    $searchTerm = strip_tags(mysqli_real_escape_string($conn, $_GET['location']));

    $country = "United Kingdom";

    $location = $searchTerm . " " . $country;

    $url = 'https://nominatim.openstreetmap.org/search/'.rawurlencode($location).'?format=json&countrycode=gb&limit=1&email=youremail@gmail.com';

    $data = ''; // empty post
    $opts = array(
        'http' => array(
            'header' => "Content-type: text/html\r\nContent-Length: " . strlen($data) . "\r\n",
            'method' => 'POST'
        ),
    );
    // Create a stream
    $context = stream_context_create($opts);
    // Open the file - get the json response using the HTTP headers set above
    $jsonfile = file_get_contents($url, false, $context);
    // decode the json
    if (!json_decode($jsonfile, TRUE)) {return false;}else{
        //if (empty(array_filter($resp))) {return false;}else{
        $resp = json_decode($jsonfile, true);
        //if(is_string($resp)){$resp = 'true';}else{$resp = 'itsnot';}
        // Extract data (e.g. latitude and longitude) from the results
        $latitude = $resp[0]['lat'];
        $longitude = $resp[0]['lon'];
        $name = $resp[0]['display_name'];
    }
}

