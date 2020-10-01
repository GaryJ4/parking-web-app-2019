<?php
session_start();

if (!isset($_SESSION['u_id'])) {
    header('Location: login');
    exit();
} else {
    include 'dbh.inc.php';
    $slug = $_GET['id'];
    $userid = $_SESSION['u_id'];

    $sql = "SELECT * FROM properties WHERE slug='$slug' AND user_id='$userid'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck < 1) {
        header("Location: profile");
        exit();
    } else {
        return true;
    }
}