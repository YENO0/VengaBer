<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Deactivate</title>
        <link href="css/editCust.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <?php
        require_once './config/php.php';
        include './header1.php';
        ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //retreive record and display
    //retreive id from URL
    (isset($_GET["username"])) ? $username = strtoupper(trim($_GET["username"])) : $username = "";
    //STEP 1 :Establish db connection
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    //remove all the special character in the id
    $username = $con->real_escape_string($username); //real_escape_string
    //SQL Statement
    $sql = "SELECT * FROM loginc WHERE UserID = '$username'";
    //To execute/run the query above
    $result = $con->query($sql);

    if ($record = $result->fetch_object()) {//fetch_object
        //record found
        $username = $record->UserID;
        $email = $record->Email;
        $password = $record->Password;
        $fname = $record->Fname;
        $lname = $record->Lname;
        $contact = $record->Contact;
        $street = $record->Street;
        $town = $record->Town;
        $postcode = $record->Postcode;
        $state = $record->State;
        $gender = $record->Gender;

        
        printf("
                    <center><h1>Are you sure you want to deactivate your Trend Paradise account?</h1>
<p class='parag'>By deactivating Your Trend Paradise account:</p><br>
->You will no longer have access to your Trend Paradise Member profile.

</center>
<br />
<center>
<form action ='' method='POST'>
<input type='submit' value='Yes' name='btnYes' class='deactivatebtn'/>
<input type='button' value='Cancel' name='btnCancel' class='deactivatebtn'
onclick='location=\"editAcc.php\"'/>
<input type='hidden' name='hduserID' value='%s'/>
<input type='hidden' name='hdFname' value='%s'/>
<input type='hidden' name='hdLname' value='%s'/>

</form></center>
                         ", $username, $fname, $lname);
    } else {
        //record not found
        echo"<div class='msg'><center>No record found![<a href='homepage.php'>Back to Homepage</a>]</center></div>";
    }
    $con->close();
    $result->free();
} else {
    //POST method
    //continue to delete record
    //retreive hidden field
    $username = strtoupper(trim($_POST["hduserID"]));
    $fname = strtoupper(trim($_POST["hdFname"]));
    $lname = strtoupper(trim($_POST["hdLname"]));
    //step 1 :establish connection
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    //Step 2 sql statement
    $sql = "DELETE FROM loginc WHERE UserID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        //record deleted
        echo"<div>Your account $username has been deactivated.[<a href='homepage.php'>Back to Homepage</a>]</div>";
    } else {
        //unable to delete
        echo"<div class='msg'>Unable to deactivate account!<a href='homepage.php'>Back to Homepage</a></div>";
    }
}
?>


<?php
        include './footer1.php';
        ?>
    </body>
</html>
