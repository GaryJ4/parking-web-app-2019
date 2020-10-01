<?php

if (isset($_POST['submit'])){

    include 'dbh.inc.php';

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $county = mysqli_real_escape_string($conn, $_POST['county']);
    $postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);

    //Error handlers
    //Check for empty fields
    if (empty($name) || empty($phone) || empty($email) || empty($address) || empty($city) || empty($county) || empty($postcode) || empty($country)) {
        header("Location: ../staff?signup=empty");
        exit();
    } else {
        //Check if input characters are valid
        if (false) {
            header("Location: ../staff?signup=invalid");
            exit();
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../staff?signup=email");
                exit();
            } else {
                //Check if email is registered
                $sql = "SELECT * FROM customers WHERE email='$email'";
                $result = mysqli_query($conn, $sql);

                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                    header("Location: ../staff?signup=emailtaken");
                    exit();
                } else {
                    $sqlInsert = "INSERT INTO customers (customerName, phone, email, addrLine1, addrCity, addrCounty, addrPostcode, addrCountry) VALUES ('$name', '$phone', '$email', '$address', '$city', '$county', '$postcode', '$country')";

                    mysqli_query($conn, $sqlInsert);

                    header("Location: ../staff?signup=success");
                    exit();
                }
            }
        }
    }
} else {
    header("Location: ../index");
    exit();
}

