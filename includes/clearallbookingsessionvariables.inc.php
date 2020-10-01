<?php

session_start();
include 'dbh.inc.php';

    //Used to delete all booking related session variables
    foreach($_SESSION as $key => $val)
    {
        if ($key !== 'u_id' && $key !== 'u_first' && $key !== 'u_last' && $key !== 'u_email' && $key !== 'u_userType' && $key !== 'webconfirmation')
        {
            unset($_SESSION[$key]);
        }

    }