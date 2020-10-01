<?php

if (isset($_POST['submit'])){

    include 'dbh.inc.php';
    include 'functions.inc.php';



    $firstName = strip_tags(mysqli_real_escape_string($conn, $_POST['firstName']));
    $lastName = strip_tags(mysqli_real_escape_string($conn, $_POST['lastName']));
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $dateOfBirth = ''. changedate($_POST['dateOfBirth']) .'';
    $inputDoB = date("Y-m-d", strtotime($dateOfBirth));

    //Error handlers
    //Check for empty fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        header("Location: ../index?signup=empty");
        exit();
    } else {
        //Check if input characters are valid
        if (!preg_match("/^[a-zA-Z]*$/", $firstName) || !preg_match("/^[a-zA-Z]*$/", $lastName) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../index?signup=invalid");
            exit();
        } else {
            //Check if email is already registered
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);

            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                header("Location: ../index?signup=usertaken");
                exit();
            } else {
                //Hashing password
                $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                $sqlInsert = "INSERT INTO users (first_name, last_name, email, password, date_of_birth) VALUES ('$firstName', '$lastName', '$email', '$hashedPwd', '$inputDoB')";
                $result = mysqli_query($conn, $sqlInsert);


                //Log user in and redirect to profile page
                session_start();
                $sql = "SELECT * FROM users WHERE email='$email'";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck < 1) {
                    header("Location: ../login?login=error");
                    exit();
                } else {
                    if ($row = mysqli_fetch_assoc($result)) {
                        //De-Hashing password
                        $hashedPwdCheck = password_verify($password, $row['password']);
                        if ($hashedPwdCheck == false) {
                            header("Location: ../login?login=error");
                            exit();
                        } else if ($hashedPwdCheck == true) {
                            //Log in the user here
                            $_SESSION['u_id'] = $row['id'];
                            $_SESSION['u_first'] = $row['first_name'];
                            $_SESSION['u_last'] = $row['last_name'];
                            $_SESSION['u_email'] = $row['email'];


                            header("Location: ../profile");
                            exit();
                        }
                    }
                }
            }
        }
    }

} else {
    header("Location: ../index");
    exit();
}


