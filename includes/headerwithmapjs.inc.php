<?php

if (isset($_SESSION['u_id'])) {
    include 'sessionExpire.inc.php';
}

session_start();


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php
        if (isset($pageTitle)) {
            echo $pageTitle . "Parking App";
        } else {
            echo "Parking App";
        }?></title>
    <meta name="author" content="name">
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">



    <!-- Favicons -->
    <link rel="icon" type="image/png" href="img/icons/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="img/icons/favicon-16x16.png" sizes="16x16" />


    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Cardo|Montserrat" rel="stylesheet">


    <!-- MapBox JS -->
    <script src='https://api.mapbox.com/mapbox.js/v3.1.1/mapbox.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/v3.1.1/mapbox.css' rel='stylesheet' />



    <!-- Date Time Picker JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">



    <script src="js/javascript.js"></script>


    <?php
    if (isset($_SESSION['u_id'])) {
        echo '<!-- Responsive Stylesheets Using Media Queries -->';
        echo '<link href="css/loggedinunder500.css" rel="stylesheet" media="screen and  (max-width:500px)" type="text/css" />';
        echo '<link href="css/loggedinunder768.css" rel="stylesheet" media="screen and (min-width:501px) and (max-width:768px)" type="text/css" />';
        echo '<link href="css/loggedinunder1200.css" rel="stylesheet" media="screen and (min-width:769px) and (max-width:1200px)" type="text/css" />';
        echo '<link href="css/loggedinover1200.css" rel="stylesheet" media="screen and (min-width:1201px)" type="text/css" />';


    } else {
        echo '<!-- Responsive Stylesheets Using Media Queries -->';
        echo '<link href="css/under500.css" rel="stylesheet" media="screen and  (max-width:500px)" type="text/css" />';
        echo '<link href="css/under768.css" rel="stylesheet" media="screen and (min-width:501px) and (max-width:768px)" type="text/css" />';
        echo '<link href="css/under1200.css" rel="stylesheet" media="screen and (min-width:769px) and (max-width:1200px)" type="text/css" />';
        echo '<link href="css/over1200.css" rel="stylesheet" media="screen and (min-width:1201px)" type="text/css" />';
    }

    ?>


</head>
<body>



<header>
    <nav>
        <ul>
            <li><a href="index" id="home-anchor">Home</a></li>
            <li><a href="search" id="search-anchor">Search</a></li>


            <?php
            if (isset($_SESSION['u_id']) && $_SESSION['u_userType'] == 2) {
                //echo '<li><a href="admin" id="admin-anchor">Admin</a></li>';
            }
            ?>
        </ul>



        <div class="nav-login">
            <?php
            if (isset($_SESSION['u_id'])) {
                echo '<a href="profile" style="margin:15px 20px; padding:0"><img src="img/icons/profile-thumbnail.svg" style="height:30px; margin:0;"/></a>';
                echo '<form action="includes/logout.inc.php" method="POST">
                                <button class="btn btn-default" type="submit" name="submit">Logout</button>
                              </form>';
            } else {
                echo '<a class="btn btn-default" href="register">Register</a>
                  <a class="btn btn-default" href="login">Login</a>';
            }
            ?>
        </div>

    </nav>

</header>