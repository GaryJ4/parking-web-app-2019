<?php

if (isset($_SESSION['u_id'])) {


    include 'dbh.inc.php';


    $userid = $_SESSION['u_id'];
    $userfirstname = $_SESSION['first_name'];
    $userlastname = $_SESSION['last_name'];

    $sql = "SELECT bookings.*, properties.*, users.first_name, users.last_name, cities.city_name FROM bookings, properties, users, cities WHERE bookings.user_id='$userid' 
            AND properties.id=bookings.property_id AND properties.user_id=users.id AND properties.city_id=cities.id ORDER BY bookings.check_in_date ASC";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($result)) {

        $hostname = $row['first_name'] . " " . $row['last_name'];
        $propertyname = $row['name'];
        $propertydescription = $row['description'];
        $address = $row['address'];
        $city = $row['city_name'];

        $checkindate = $row['check_in_date'];
        $checkintime = $row['check_in_time'];
        $checkoutdate = $row['check_out_date'];
        $checkouttime = $row['check_out_time'];

        $price = $row['effective_amount'];

        $bookingdatetime = explode(" ", $row['booking_date']);
        $bookingdate = $bookingdatetime[0];


        if ($checkindate >= date('Y-m-d')) {
            echo '<div class="booking-active">';
                echo '<h5>Property Name: '.$propertyname.'</h5>';
                echo '<p>Host Name: '.$hostname.'</p>';
                echo '<p>Arrival Date: '.changedatereverse($checkindate).' at '.$checkintime.'</p>';
                echo '<p>Departure Date: '.changedatereverse($checkoutdate).' at '.$checkouttime.'</p>';
                echo '<p>Address: '.$address.', '. $city.'</p>';
                echo '<p>Price: £'.$price.'</p>';
                echo '<p>Booked on: '.changedatereverse($bookingdate).'</p>';
            echo '</div>';
        }
    }
}