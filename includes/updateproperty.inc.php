<?php


if (isset($_POST['submit'])) {

    session_start();

    include 'dbh.inc.php';
    include 'functions.inc.php';

    $propertyName = strip_tags(mysqli_real_escape_string($conn, $_POST['name']));
    $propertyDescription = strip_tags(mysqli_real_escape_string($conn, $_POST['description']));
    $address = strip_tags(mysqli_real_escape_string($conn, $_POST['address']));
    $postcode = mysqli_real_escape_string($conn, $_POST['[postcode']);
    $city = strip_tags(mysqli_real_escape_string($conn, $_POST['city']));
    $county = mysqli_real_escape_string($conn, $_POST['county']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $postcode = strip_tags(mysqli_real_escape_string($conn, $_POST['postcode']));
    $carCount = mysqli_real_escape_string($conn, $_POST['car-count']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $propertyid = $_SESSION['propertyid'];
    $availability = $_POST['availability'] - 1;




    //Get City ID from name
    $sqlSelect = "SELECT * FROM cities WHERE city_name='$city'";
    $result = mysqli_query($conn, $sqlSelect) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);

    $cityid = $row['id'];
    $countyid = $row['county_id'];

    //Get Country ID from name
    $sqlSelect = "SELECT country_id FROM counties WHERE id='$countyid'";
    $result = mysqli_query($conn, $sqlSelect) or die(mysqli_error($conn));;
    $row = mysqli_fetch_assoc($result);

    $countryid = $row['country_id'];

    $userid = $_SESSION['u_id'];


    //API.Postcodes URL to get Lat and Lon of property address from value of Postcode
    $url = "https://api.postcodes.io/postcodes/" . $postcode;

    ini_set("allow_url_fopen", 1);
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);

    $latitude = $json_data['result']['latitude'];
    $longitude = $json_data['result']['longitude'];


    $sqlUpdate = "UPDATE properties SET name='$propertyName', description='$propertyDescription', user_id='$userid', country_id='$countryid', 
                  county_id='$countyid', city_id='$cityid', address='$address', postcode='$postcode', latitude='$latitude', longitude='$longitude', 
                  car_space_count='$carCount', availability_type='$availability', price='$price' WHERE id='$propertyid'";



    $result = mysqli_query($conn, $sqlUpdate);


    header("Location: ../profile");
    exit();


}

