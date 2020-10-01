<?php

if (isset($_SESSION['u_id'])) {


    include 'dbh.inc.php';


    $userid = $_SESSION['u_id'];
    $userfirstname = $_SESSION['first_name'];
    $userlastname = $_SESSION['last_name'];

    $sql = "SELECT properties.*, countries.country_name, cities.city_name, counties.county_name FROM properties, countries, cities, counties WHERE properties.user_id='$userid' 
            AND properties.country_id=countries.id AND properties.city_id=cities.id AND properties.county_id=counties.id";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($result)) {

        $hostname = $row['first_name'] . " " . $row['last_name'];
        $propertyname = $row['name'];
        $propertydescription = $row['description'];

        $address = $row['address'];
        $city = $row['city_name'];
        $county = $row['county_name'];
        $country = $row['country_name'];
        $slug = $row['slug'];
        $price = $row['price'];

        echo '<div class="individual-property-container">';
            echo '<a href="viewproperty?id='.$slug.'"><h3>'.$propertyname.'</h3></a>';
            echo '<a class="btn btn-default" id="edit-property-button" href="editproperty?id='.$slug.'">Edit Property</a>';
            echo '<p>'.$propertydescription.'</p>';
            echo '<p>'.$address.', '.$city.', '.$county.', '.$country.'</p>';


        echo '</div>';

    }

}

