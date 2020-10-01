<?php
session_start();

if (!isset($_SESSION['u_accessLevel'])) {
    header('Location: index');
    exit();
} else {
    if ($_SESSION['u_accessLevel'] != 5) {
        header('Location: index');
        exit();
    }
}