<?php

include 'dbh.inc.php';

//Used to display date in MySQL format yyy-mm-dd
function changedate($date) {
    $chdate = explode('/',$date);
    $changedate = $chdate[2].'-'.$chdate[1].'-'.$chdate[0];
    return $changedate;
}


//Used to display date in readable format dd/mm/yyyy
function changedatereverse($date) {
    $chdate = explode('-',$date);
    $changedate = $chdate[2].'/'.$chdate[1].'/'.$chdate[0];
    return $changedate;
}


//Used to convert text to URL slug format this-is-a-slug
function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}


//Used to validate time
function timeValidation($str){
    if (preg_match('/^\d{2}:\d{2}$/', $str)) {
        if (preg_match("/(2[0-3]|[0][0-9]|1[0-9]):([0-5][0-9])/", $str)) {
            return $str;
        } else {
            return "09:00";
        }
    }
}


/*
 *
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 */