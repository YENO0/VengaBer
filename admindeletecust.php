<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>DELETE CUSTOMER</title>
        <link href="css/manageUser.css" rel="stylesheet" type="text/css"/>
    </head>

    <body style="background-image:url('images/3.jpg');background-size:cover;background-repeat:no-repeat;">
        <?php
        require_once './config/php.php';
        include './adminHeader1.php';
        global $hideform;
        global $adminid;
        ?>
        <?php
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //STEP 2: SQL statement
        $sql = "SELECT * FROM logina";

//STEP 3:Execute sql
        $result = $con->query($sql);
        if ($record = $result->fetch_object()) {
            //record found
            $adminid = $record->AdminID;
            $fname = $record->Aname;
            $email = $record->Aemail;
            $contact = $record->Acontact;
            $password = $record->Apassword;
            $gender = $record->Agender;
            $street = $record->Astreet;
            $town = $record->ATown;
            $postcode = $record->APostcode;
            $state = $record->AState;
        } else {
            echo "<center><div class='msg'>You haven't Log In![<a href='login-admin.php'>LOG IN</a>]</div></center>";
            $hideform = true;
        }
        $con->close();
        $result->free();
        ?>
        <?php if ($hideform == false): ?>
            <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            //retreive record and display
            //retreive id from URL
            (isset($_GET["username"])) ? $username = strtoupper(trim($_GET["username"])) : $username = "";
            //STEP 1 :Establish db connection
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            //remove all the special character in the id
            $username = $con->real_escape_string($username);

            //SQL Statement
            $sql = "SELECT * FROM loginc WHERE UserID = '$username'";
        //To execute/run the query above
            $result = $con->query($sql);

            if ($record = $result->fetch_object()) {
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
                    
<table class='deletecusttable'>
<tr>
<td class='trdelete'>User ID:</td>
<td class='trdelete'>%s</td>
</tr>
<tr>
<td class='trdelete'>Email:</td>
<td class='trdelete'>%s</td>
</tr>
<tr>
<td class='trdelete'>First Name:</td>
<td class='trdelete'>%s</td>
</tr>
<tr>
<td class='trdelete'>Last Name:</td>
<td class='trdelete'>%s</td>
</tr>
<tr>
<td class='trdelete'>Contact:</td>
<td class='trdelete'>%s</td>
</tr>
<tr>
<td class='trdelete'>Street:</td>
<td class='trdelete'>%s</td>
</tr>
<tr>
<td class='trdelete'>Town/City:</td>
<td class='trdelete'>%s</td>
</tr>
<tr>
<td class='trdelete'>Postcode:</td>
<td class='trdelete'>%s</td>
</tr>
<tr>
<td class='trdelete'>State:</td>
<td class='trdelete'>%s</td>
</tr>
<tr>
<td class='trdelete'>Gender:</td>
<td class='trdelete'>%s</td>
</tr>

</table>
<br />
<br />
<form action ='' method='POST'>
<center><input type='submit' value='Yes' name='btnYes' class='yesorcancel'/></center>
<center><input type='button' value='Cancel' name='btnCancel' class='yesorcancel'
onclick='location=\"manageuser.php\"'/></center>
<input type='hidden' name='hduserID' value='%s'/>
<input type='hidden' name='hdFname' value='%s'/>
<input type='hidden' name='hdLname' value='%s'/>

</form>
                         ", $username, $email, $fname, $lname, $contact, $street, $town, $postcode, $state, getGender()[$gender], $username, $fname, $lname);
            } else {
                //record not found
                echo"<div class='msg'>No record found![<a href='homepage.php'>Back to Homepage</a>]</div>";
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
                echo"<div>Your account $username has been deactivated.[<a href='admin-homepage.php'>Back to Homepage</a>]</div>";
        } else {
                //unable to delete
                echo"<div class='msg'>Unable to deactivate account!<a href='homepage.php'>Back to Homepage</a></div>";
            }
        }
        ?>

        <?php endif; ?>

    </body>
</html>