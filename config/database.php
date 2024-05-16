<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

define('DB_HOST', "yy-ver1-rds.ctqigw62kpxk.us-east-1.rds.amazonaws.com");
define('DB_USER', "yen0809");
define('DB_PASS', "p3TEr100");
define('DB_NAME', "PETER");

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


//check student ID
function promotionCode($code){
    if($code == NULL){
        return "Please enter a <b>PROMOTION CODE</b>";
    }else if(!preg_match('/^[A-Z]{2}[0-9]{6}$/', $code)){
        return "Invalid <b>PROMOTION CODE</b>";
    }else if(promotionCodeExist($code)){
        //check duplicated student ID
        return "Same <b>PROMOTION CODE</b> detected. Please try again.";
    }
}

//check existing student ID
function promotionCodeExist($code){
    $exist = false;
    
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $sql = "SELECT * FROM promotiong WHERE PromotionCode = '$code'";
    
    if($result = $con -> query($sql)){
        if($result -> num_rows > 0){
            //record found
            $exist = true;
        }
    }
    $result -> free();
    $con -> close();
    
    return $exist;
}

////check customer username 
//function checkUsername($username){
//    if($username == NULL){
//        return "Please enter your <b>USERNAME</b>to login.";
//    }else if(!preg_match('/^[A-Z]{8}$/', $username)){
//        return "Invalid <b>USERNAME</b>.";
//    }
//}
//
//function checkPassword($password){
//    if($password == NULL){
//        return "Please enter your <b>PASSWORD</b>to login.";
//    }else if(!preg_match('/^[0-9]{6}$/',$password)){
//        return "Incorrect <b>PASSWORD</b>";
//    }
//}
//
//function chackEmail($email){
//    if($email == NULL){
//        return "Please enter your <b>Email</b>to login.";
//    }else if(!preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/',$email)){
//        return "Incorrect <b>Email</b>.";
//    }
//}