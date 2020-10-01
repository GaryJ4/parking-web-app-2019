<?php

if (isset($_GET['id'])) {

    session_start();

    include 'dbh.inc.php';

    $slug = strip_tags(mysqli_real_escape_string($conn, $_GET['id']));


    $sql = "SELECT users.first_name, users.last_name, properties.* FROM users, properties WHERE properties.slug='$slug' 
            AND properties.user_id=users.id";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        //Host Details
        $hostid = $row['user_id'];
        $hostname = $row['first_name'] . " " . $row['last_name'];

        //Property Details
        $propertyid = $row['id'];
        $propertyname = $row['name'];
        $description = $row['description'];
        $slug = $row['slug'];
        $address = $row['address'];
        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        $car_space_count = $row['car_space_count'];
        $postcode = $row['postcode'];


        //Property Price Per Day
        $priceperday = $row['price'];
        $availability = $row['availability_type'];




        //Get City, County, Country Names of property
        $sqlNames = "SELECT cities.city_name, counties.county_name, countries.country_name, properties.* 
                    FROM properties, cities, counties, countries WHERE properties.id='$propertyid' 
                    AND properties.city_id = cities.id AND properties.county_id=counties.id AND properties.country_id=countries.id";

        $result = mysqli_query($conn, $sqlNames);
        $row = mysqli_fetch_array($result);

        $city = $row['city_name'];
        $county = $row['county_name'];
        $country = $row['country_name'];

    } else {
        $error = "Property Not Found - ";
    }
}

