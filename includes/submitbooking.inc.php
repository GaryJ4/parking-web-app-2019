<?php

if (isset($_POST['submit'])) {

    include 'dbh.inc.php';
    include 'functions.inc.php';
    session_start();

    $propertyid = $_SESSION['propertyid'];
    $userid = $_SESSION['u_id'];
    $totalprice = $_SESSION['totalprice'];
    $taxpaid = $totalprice * 0.2; //20% tax
    $sitefees = $totalprice * 0.1; //10% site fee

    $checkindate = $_SESSION['arrdate'];
    $checkoutdate = $_SESSION['depdate'];
    $checkintime = $_SESSION['arrtime'];
    $checkouttime = $_SESSION['deptime'];







    //Make transaction
    //$sql = "INSERT INTO transactions (property_id, receiver_id, payee_id, site_fees, amount, transfer_on, )";

    //Make Booking
    $sql = "INSERT INTO bookings (property_id, user_id, check_in_date, check_in_time, check_out_date, check_out_time, price_for_stay, effective_amount) 
            VALUES ('$propertyid', '$userid', '$checkindate', '$checkintime', '$checkoutdate','$checkouttime', '$totalprice', '$totalprice')";

    $result = mysqli_query ($conn, $sql) or die (mysqli_error($conn));






    //Create Email Confirmation


    $name = $_SESSION['u_first'];
    $email = "garyjackson200@gmail.com"; //Company Email Address
    $subject = "Booking Confirmation - ".$_SESSION['propertyname'];

    $recipient = $_SESSION['u_email'];

    //Email Confirmation
    $emailconfirmation = "Hi ". $_SESSION['u_first'] .", thank you for your booking at " .$_SESSION['propertyname']."
                From: ".changedatereverse($_SESSION['arrdate'])." at ".$_SESSION['arrtime']."
                Until: ".changedatereverse($_SESSION['depdate'])." at ".$_SESSION['deptime']."";

    //Website Confirmation - Used on Booking Confirmation Page
    $webconfirmation = "<p>Location: ".$_SESSION['address']."</p><br>
                        <p>From: ".changedatereverse($_SESSION['arrdate'])." at ".$_SESSION['arrtime']."</p><br>
                        <p>Until: ".changedatereverse($_SESSION['depdate'])." at ".$_SESSION['deptime']."</p>";

    $_SESSION['webconfirmation'] = $webconfirmation;

    //$formcontent = "Name: $name \n\nEmail: $recipient \n\nMessage: \n\n$message\n\n";



    $mailheader = "From: $email \r\n";
    mail($recipient, $subject, $emailconfirmation, $mailheader) or die("Error!");
    //Email Sent



    header("Location: ../bookingconfirmation");
    exit();

} else {
    header("Location: ../index?fail");
    exit();
}