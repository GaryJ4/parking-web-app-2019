<?php

if (isset($_POST['submit'])){

    include 'dbh.inc.php';

    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $accessLevel = mysqli_real_escape_string($conn, $_POST['accessLevel']);

    //Error handlers
    //Check for empty fields
    if (empty($firstName) || empty($lastName) || empty($userName) || empty($password) || empty($accessLevel)) {
        header("Location: ../admin?signup=empty");
        exit();
    } else {
        //Check if input characters are valid
        if (!preg_match("/^[a-zA-Z]*$/", $firstName) || !preg_match("/^[a-zA-Z]*$/", $lastName) || !preg_match("/^[a-zA-Z0-9]*$/", $userName) || !preg_match("/^[1-5]$/", $accessLevel)) {
            header("Location: ../admin?signup=invalid");
            exit();
        } else {
            //Check if username is valid
            $sql = "SELECT * FROM staff WHERE userName='$userName'";
            $result = mysqli_query($conn, $sql);

            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                header("Location: ../admin?signup=usertaken");
                exit();
            } else {
                //Hashing password
                $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                $sqlInsert = "INSERT INTO staff (firstName, lastName, userName, pwd, accessLevel) VALUES ('$firstName', '$lastName', '$userName', '$hashedPwd', '$accessLevel')";

                mysqli_query($conn, $sqlInsert);

                header("Location: ../admin?signup=success");
                exit();
            }
        }
    }

} else {
    header("Location: ../index");
    exit();
}


