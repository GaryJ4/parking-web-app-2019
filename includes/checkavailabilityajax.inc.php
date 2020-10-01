<?php

session_start();

if (isset($_POST['arrdate']) && isset($_POST['depdate'])) {

    include "dbh.inc.php";

    $arrdate = $_POST['arrdate'];
    $depdate = $_POST['depdate'];
    $propertyid = $_SESSION['propertyid'];

    $sql = "SELECT properties.*, COUNT(bookings.property_id) AS number_of_bookings 
            FROM properties, bookings WHERE properties.id='$propertyid' AND (bookings.check_in_date 
            BETWEEN '$arrdate' AND '$depdate') OR (bookings.check_out_date BETWEEN '$arrdate' AND '$depdate') 
            GROUP BY properties.id LIMIT 1";

    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_array($result);

    $spacesLeft = $row['car_space_count'] - $row['number_of_bookings'];

    if ($row['number_of_bookings'] < $row['car_space_count']) {
        echo '<p>There are '.$spacesLeft. ' spaces left</p>';
    } else {
        echo '<p>No Space Left</p>';
    }

}





