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
    <title><?php echo $pageTitle ?></title>
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



    <script src="js/javascript.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

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
    <!-- Company Logo  <img src="#"/>    -->
    <p style="text-align: center"><a href="index">Parking App Logo Placeholder</a></p>
</header>
