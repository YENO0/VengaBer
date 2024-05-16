<?php
define('DB_HOST', "yy-ver1-rds.ctqigw62kpxk.us-east-1.rds.amazonaws.com");
define('DB_USER', "yen0809");
define('DB_PASS', "p3TEr100");
define('DB_NAME', "PETER");

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

function getState() {
    return array(
        'PERLIS' => 'PERLIS',
        'KEDAH' => 'KEDAH',
        'PENANG' => 'PENANG',
        'PERAK' => 'PERAK',
        'SELANGOR' => 'SELANGOR',
        'NEGERI SEMBILAN' => 'NEGERI SEMBILAN',
        'MELAKA' => 'MELAKA',
        'JOHOR' => 'JOHOR',
        'KELANTAN' => 'KELANTAN',
        'TERENGGANU' => 'TERENGGANU',
        'PAHANG' => 'PAHANG',
        'SABAH' => 'SABAH',
        'SARAWAK' => 'SARAWAK'
    );
}

function getGender() {
    return array(
        'm' => 'Male',
        'f' => 'Female'
    );
}
function changeP($npassword, $cpassword) {
    if ($npassword == NULL || $cpassword == NULL) {
        return"New Password cannot be blank!";
    } else if (strcmp($npassword, $cpassword) != 0) {
        return"New Password not match!";
    
    }
}



function checkRpt($password, $rptpass) {
    if ($password == NULL || $rptpass == NULL) {
        return"Password cannot be blank!";
    } else if (strcmp($password, $rptpass) != 0) {
        return"Password not match!";
    }
}
function checkAdd($street, $town, $postcode, $state) {
    if ($street == NULL || $town == NULL || $postcode == NULL || $state == NULL) {
        return"Please enter the address!";
    } else if (strlen($street) > 50 || strlen($town) > 50 || strlen($postcode) > 5 || strlen($state) > 50) {
        return"Something wrong with your address!";
    }
}

function checkUsername($username) {
    if ($username == NULL) {
        return"Please enter your Username!";
    } else if (strlen($username) > 30) {
        return"Your Username exceed the maximum characters(Maximum 30).";
    } else if (!preg_match('/^[A-Za-z0-9]+$/', $username)) {
        return"Invalid character(s) detected";
    } else if (custExist($username)) {
        //check duplicated student ID
        return "The username already exists!.Please try again.";
    }
}
function editEmail($email) {
    if ($email == null) {
        return "Please enter your Email!";
    } else if (!preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $email)) {
        return"Invalid Email!";
    }
}

function checkEmail($email) {
    if ($email == null) {
        return "Please enter your Email!";
    } else if (!preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $email)) {
        return"Invalid Email!";
    
    } else if (custemailExist($email)) {
        return "The email already exists!.Please try again.";
    }
}

function checkfname($fname) {
    if ($fname == null) {
        return"Please enter your First Name!";
    } else if (strlen($fname) > 30) {
        return"Your First Name exceed the maximum characters(Maximum 30).";
    } else if (!preg_match('/^[A-Za-z ]+$/', $fname)) {
        return"Invalid character(s) detected in your First Name";
    }
}

function checklname($lname) {
    if ($lname == null) {
        return"Please enter your Last Name!";
    } else if (strlen($lname) > 30) {
        return"Your Last Name exceed the maximum characters(Maximum 30).";
    } else if (!preg_match('/^[A-Za-z ]+$/', $lname)) {
        return"Invalid character(s) detected in your Last Name";
    }
}

function checkContact($contact) {
    if ($contact == null) {
        return"Please enter your Phone Number!";
    } else if (!preg_match('/^01[0-9]\d{7,8}$/', $contact)) {
        return"Incorrect Phone Number format!";
    }
}

function checkGender($gender) {
    if ($gender == null) {
        return"Please select your Gender";
    } else if (!array_key_exists($gender, getGender())) {
        return"Invalid GENDER!";
    }
}

function checkScode($securityCode) {
    if ($securityCode == NULL) {
        return"Please enter your Security Code";
    } else if (strlen($securityCode) > 20) {
        return"Your security code exceed the maximum characters(Maximum20).";
}
}

function custemailExist($email){
$exist = false;
//Step 1 of database: connect PHP with database
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
//Step 2 :sql statement
    $sql = "SELECT * FROM loginc WHERE Email = '$email'";

//step 3: run sql
if ($result = $con->query($sql)) {
if ($result->num_rows > 0) {
//record found
$exist = true;
}
}
//Step  4: close connection, free result
$result->free();
$con->close();

return $exist;
}



function custExist($username) {
    $exist = false;
    //Step 1 of database: connect PHP with database
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    //Step 2 :sql statement
    $sql = "SELECT * FROM loginc WHERE UserID = '$username'";

    //step 3: run sql
    if ($result = $con->query($sql)) {
        if ($result->num_rows > 0) {
            //record found
            $exist = true;
        }
    }
    //Step  4: close connection, free result
    $result->free();
    $con->close();

    return $exist;
}

function checkAdminID($adminid) {
    if ($adminid == NULL) {
        return"Please enter your Username!";
    } else if (strlen($adminid) > 5) {
        return"Your Username exceed the maximum characters(Maximum 30).";
    } else if (!preg_match('/^[S][0-9]{4}$/', $adminid)) {
        return"Invalid character(s) detected";
    } else if (staffExist($adminid)) {
        //check duplicated staffID
        return "The Staff ID already exists!.Please try again.";
    }
}

function staffExist($adminid) {
    $exist = false;
    //Step 1 of database: connect PHP with database
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    //Step 2 :sql statement
    $sql = "SELECT * FROM logina WHERE AdminID = '$adminid'";

    //step 3: run sql
    if ($result = $con->query($sql)) {
        if ($result->num_rows > 0) {
            //record found
            $exist = true;
        }
    }
    //Step  4: close connection, free result
    $result->free();
    $con->close();

    return $exist;
}
