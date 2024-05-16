<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->

<html>
    <head>
        <?php
        global $hideform;
        ?>
        <meta charset="UTF-8">
        <title>CHANGE PASSWORD</title>
        <link rel="stylesheet" href="css/editCust.css"type="text/css"/>
    </head>
    <body style="background-image: url('image./background_3.jpg'); 
          background-repeat: no-repeat; background-size: cover; 
          background-position: center;">
        <?php
        require_once './config/php.php';
        include './header1.php';
        ?>
        <?php
        if (isset($_COOKIE['UserID'])) {
            $username = $_COOKIE['UserID'];
        } else {
            echo "<center><div class='msg'>You haven't Log In![<a href='login-customer.php'>LOG IN</a>]</div></center>";
        }
        ?>
        <div class="dropdown">
            <button class="accBtn"><img src="images/Myaccount.png" class="logo1"/></button>
            <div class="accContent">
                <h3>My Account</h3>
                <?php
                $username = $_GET["username"];
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

if ($result = $con->query($sql)) {
                    while ($record = $result->fetch_object()) {
                        printf("
                <a href='editAcc.php?username=%s' class='content'>Profile</a>
                <a href='editAdd.php?username=%s' class='content'>Address</a>
                <a href='changePass.php?username=%s' class='content'>Password</a>
                             ", $record->UserID, $record->UserID, $record->UserID);
                    }
                }
                $result->free();
                $con->close();
                ?>

            </div>
        </div>

        <?php
//perform "GET" function to retrieve id from url and then retrieve record from DB.dislay in the form
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //perform GET method
            //retrieve Studen ID from URL
            (isset($_GET['username'])) ?
                            $username = strtoupper(trim($_GET['username'])) :
                            $username = "";

            //STEP 1: connect
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            //STEP 2: SQL statement
            $sql = "SELECT * FROM loginc WHERE UserID = '{$_COOKIE['UserID']}'";

    //STEP 3:Execute sql
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
            } else {
                echo "<center><div class='msg'>No record found![<a href='homepage.php'>Back to home</a>]</div></center>";
                $hideform = true;
            }
            $con->close();
            $result->free();
        } else {
            //perform POST method
            //hint:very similar to insert  function
            //retrieve  input from user
            $username = strtoupper(trim($_POST["hdUser2"]));
            $rptpass = trim($_POST["rptcurrentP"]);
            $password = trim($_POST["currentP"]);
            $npassword = trim($_POST["newPass"]);
            $cpassword = trim($_POST["confirmPass"]);

            $msg["password"] = checkRpt($password, $rptpass);
            $msg["npassword"] = changeP($npassword, $cpassword);
            //remove null error
            $msg = array_filter($msg);

            if (empty($msg)) {
                //no error,can UPDATE record
                //Step 1:Establish connection
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                //Step 2 :SQL Statement
                $sql = "UPDATE loginc SET Password=? WHERE UserID = ?";
        //Step 3 : Execute SQL
                //NOTE: when we hard code sql, we will use $con->query()
                //when we use "?" method,use $con->prepare()
                $stmt = $con->prepare($sql);
                $stmt->bind_param('ss', $npassword, $username);

                if ($stmt->execute()) {
                    //record edited
                    echo "<br><center><div>Password update successful!</div></center><br>";
                } else {
                    //unable to edit
                    echo "<div class='msg'>Unable to Edit.Please try again</div>";
                }
                $con->close();
                $stmt->close();
            } else {
                //with error, display error msg
                echo"<ul class='msg'>";
                foreach ($msg as $value) {
                    echo "<center><li>$value</li></center>";
                }
                echo"</ul>";
            }
        }
        ?>

        <?php
        if ($hideform == false):
            ?>
            <form action="" method="POST">
                <table class="editAcc">
                    <input type="hidden" name="hdUser2" value="<?php echo $username; ?>" />

                    <tr class="trpass">
                    <caption><h2 class="h2acc">Change Password</h2></caption>
                    </tr>
                    <tr class="trpass">
                        <td class="customiao"><label for="currentP" class="head">Current Password</label></td>
                    </tr>
                    <tr class="trpass">
                        <td><input type="password" name="currentP" value="" /><a href="forgot-passwordCustomer.php">Forgot Password?</a></td>

                    </tr>
                    <tr class="trpass">
                        <td class="customiao"><label for="rptcurrentP" class="head">Repeat Password</label></td>
                    </tr>
                    <tr class="trpass">
                        <td><input type="password" name="rptcurrentP" value="" /></td>

                    </tr>
                    <tr class="trpass">
                        <td><label for="newPass" class="head">New Password</label></td>
                    </tr>
                    <tr class="trpass">
                        <td><input type="password" name="newPass" value="" /> </td>
                    </tr>
                    <tr class="trpass">
                        <td><label for="confirmPass" class="head">Confirm Password</label></td>
                    </tr>
                    <tr class="trpass">
                        <td><input type="password" name="confirmPass" value="" />
                        </td>
                    </tr>


                    <tr class="trpass">
                        <td><input type="submit" value="Save" class="savebtn" /></td>
                    </tr>
                    <?php
                    // Step 2 link php application with Database
                    //object-oriented method OOP
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    //step 3 SQL Statement
                    $sql = "SELECT * FROM loginc";

//step 4 Run SQL
                    //NOTE : $result - contains all records
                    if ($result = $con->query($sql)) {
                        if ($record = $result->fetch_object()) {
                            printf("     <tr class='trpass'>

                <td><a href='deactivate.php?username=%s' class='deactbtn'>Deactivate</a></td>
            </tr>", $record->UserID);
                        }
                    }
                    ?>
                </table>
            </form>

        <?php endif; ?>
    </body>
    <?php include './footer1.php';?>
</html>