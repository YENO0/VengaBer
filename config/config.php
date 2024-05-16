<?php

$conn = mysqli_connect('yy-ver1-rds.ctqigw62kpxk.us-east-1.rds.amazonaws.com', 'yen0809', 'p3TEr100', 'PETER');

define('DB_HOST', "yy-ver1-rds.ctqigw62kpxk.us-east-1.rds.amazonaws.com");
define('DB_USER', "yen0809");
define('DB_PASS', "p3TEr100");
define('DB_NAME', "PETER");

function getCategories(){
    return array(
        'gypsophila' => 'gypsophila',
        'mixed flower' => 'mixed flower',
        'sunflower' => 'sunflower',
        'tulip' => 'tulip',
        'twist stick' => 'twist stick'
    );
}

//validation
function checkCategories($categories){
    if($categories == null){
        return "Please Enter Product <b>CATEGORIES</b>";
    }
}

function checkPrice($price){
    if($price == null){
        return "Please Enter Product <b>PRICE</b>";
    }
}

function checkDescription($description){
    if($description == null){
        return "Please Enter Product <b>DESCRIPTION</b>";
    }
}

function checkProductName($name){
    if($name == null){
        return "Please Enter Product <b>NAME</b>";
    } else if(strlen($name)>50){
        return "Your <b>NAME</b> exceed the maximum characters";
    }
}

?>
