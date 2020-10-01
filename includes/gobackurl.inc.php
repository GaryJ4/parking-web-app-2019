<?php
session_start();

$gobackurl = $_SESSION['gobackurl'];
header("Location: ../$gobackurl");
unset($_SESSION['gobackurl']);
exit();