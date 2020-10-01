<?php
session_start();

if (isset($_POST['submit'])) {

    include 'dbh.inc.php';

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    //Error handlers
    //Check if inputs are empty

    if (empty($username) || empty($password)) {
        header("Location: ../login?login=empty");
        exit();
    } else {
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
                    header("Location: ../login?login=errorpwd");
                    exit();
                } else if ($hashedPwdCheck == true) {
                    //Log in the user here
                    $_SESSION['u_id'] = $row['id'];
                    $_SESSION['u_first'] = $row['first_name'];
                    $_SESSION['u_last'] = $row['last_name'];
                    $_SESSION['u_email'] = $row['email'];
                    $_SESSION['u_userType'] = $row['user_type'];



                    if ($_SESSION['unauthorised'] == 1) {
                        $url = $_SESSION['url'];
                        header("Location: ../$url");
                        unset($_SESSION['unauthorised']);
                        exit();
                    } else if (isset($_SESSION['url'])) {
                        $url = $_SESSION['url'];
                        header("Location: ../$url");
                        exit();
                    }else {
                        header("Location: ../index");
                        exit();
                    }
                }
            }
        }
    }

} else {
    header("Location: ../index?login=error");
    exit();
}