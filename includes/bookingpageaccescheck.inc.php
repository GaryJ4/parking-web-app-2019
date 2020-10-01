<?php
session_start();

$gobackurl = $_SESSION['gobackurl'];

$url = $_SESSION['url'];



    if (!isset($_SESSION['arrdate']) || empty($_SESSION['arrdate']) || !isset($_SESSION['arrtime']) || empty($_SESSION['arrtime']) ||
        !isset($_SESSION['depdate']) || empty($_SESSION['depdate']) || !isset($_SESSION['deptime']) || empty($_SESSION['deptime']) ||
        !isset($_SESSION['propertyid']) || empty($_SESSION['propertyid']) || !isset($_SESSION['propertyname']) || empty($_SESSION['propertyname']) ||
        !isset($_SESSION['totalprice']) || empty($_SESSION['totalprice']) || !isset($_SESSION['totaldays']) || empty($_SESSION['totaldays']))
     {
         if (isset($_SESSION['gobackurl'])) {
            header("Location: $gobackurl");
            unset($_SESSION['gobackurl']);
            exit();
        } else if (isset($_SESSION['url']) && $_SESSION['url'] != "booking"){
            header("Location: $url");
            unset($_SESSION['url']);
            exit();
        } else {
            header("Location: index");
            exit();
        }
    }
