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


    //Get City ID from name
    $sqlSelect = "SELECT * FROM cities WHERE city_name='$city'";
    $result = mysqli_query($conn, $sqlSelect) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);

    $cityid = (int)$row['id'];
    $countyid = (int)$row['county_id'];

    //Get Country ID from name
    $sqlSelect = "SELECT country_id FROM counties WHERE id='$countyid'";
    $result = mysqli_query($conn, $sqlSelect) or die(mysqli_error($conn));;
    $row = mysqli_fetch_assoc($result);

    $countryid = (int)$row['country_id'];

    $userid = (int)$_SESSION['u_id'];

    //Original Slug Generator which was 'property-name-randomnum'
    //$slug = slugify($propertyName);
    //$uniqueid = hexdec(uniqid("", false));
    //$result = substr($uniqueid, 0, 8);
    //$slug = $slug . "-" . $result;

    $slug = rand(1111111111, 9999999999);
    $resultCheck = 1;

    while ($resultCheck > 0) {

        $sqlSlugCheck = "SELECT * FROM properties WHERE slug='$slug'";
        $result = mysqli_query($conn, $sqlSlugCheck);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            $slug = rand(1111111111, 9999999999);
        }
    }


    //API.Postcodes URL to get Lat and Lon of property address from value of Postcode
    $url = "https://api.postcodes.io/postcodes/" . $postcode;

    ini_set("allow_url_fopen", 1);
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);

    $latitude = $json_data['result']['latitude'];
    $longitude = $json_data['result']['longitude'];




    $sqlInsert = "INSERT INTO properties (name, description, slug, user_id, country_id, county_id, city_id, address, postcode, latitude, longitude, car_space_count, price) VALUES ('$propertyName', '$propertyDescription', '$slug', '$userid', '$countryid', '$countyid', '$cityid', '$address', '$postcode', '$latitude', '$longitude', '$carCount', '$price')";

    $result = mysqli_query($conn, $sqlInsert);


    header("Location: ../profile");
    exit();


}

