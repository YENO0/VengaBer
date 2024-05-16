<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>ADMIN EDIT</title>
        <link href="css/adminEdit.css" rel="stylesheet" type="text/css"/>
        <?php
        global $hideform;
        ?>
    </head>
    <body style="background-image: url(images/3.jpg);background-size: cover;background-repeat: no-repeat;">
        <?php
        include './adminHeader1.php';
        require_once './config/php.php';
        ?>
        <?php
// Retrieve adminid or email from cookie, if set
        if (isset($_COOKIE['AdminID'])) {
            $adminID = $_COOKIE['AdminID'];
            $sql = "SELECT * FROM logina WHERE AdminID = '$adminID'";
} elseif (isset($_COOKIE['Aemail'])) {
            $aemail = $_COOKIE['Aemail'];
            $sql = "SELECT * FROM logina WHERE Aemail = '$aemail'";
} else {
            echo "<center><div class='msg'>You haven't logged in! [<a href='login-admin.php'>LOG IN</a>]</div></center>";
            exit();
        }


        ?>
        <?php
//perform "GET" function to retrieve id from url and then retrieve record from DB.dislay in the form
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //perform GET method
            //retrieve Studen ID from URL
            (isset($_GET['adminid'])) ?
                    $adminid = strtoupper(trim($_GET['adminid'])) :
                    $adminid = "";

    //STEP 1: connect
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            //STEP 2: SQL statement
            if (isset($_COOKIE['AdminID'])) {
                $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
    } elseif (isset($_COOKIE['Aemail'])) {
                $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
    }

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
                echo "<center><div class='msg'>No record found![<a href='homepage.php'>Back to home</a>]</div></center>";
                $hideform = true;
            }
            $con->close();
            $result->free();
        } else {
            //perform POST method
            //hint:very similar to insert  function
            //retrieve  input from user
    $adminid = strtoupper(trim($_POST["hdStaff"]));
    $email = trim($_POST["email2"]);
    $fname = trim($_POST["fname2"]);

    $contact = trim($_POST["contact2"]);
    $gender = trim($_POST["sgender"]);
    $street = trim($_POST["street2"]);
    $town = trim($_POST["town2"]);
    $postcode = trim($_POST["postcode2"]);
    $state = trim($_POST["adminState"]);

    //validation all input from helper.php

            $msg["fname"] = checkfname($fname);
     $msg["email"] = editEmail($email);
    $msg["contact"] = checkContact($contact);
            $msg["gender"] = checkGender($gender);

            //remove null error
            $msg = array_filter($msg);

            if (empty($msg)) {
                //no error,can UPDATE record
                //Step 1:Establish connection
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                //Step 2 :SQL Statement
                $sql = "UPDATE logina SET Aname=?,Aemail = ?,Acontact=?,Agender=?,Astreet=?,ATown=?,APostcode=?,AState=? WHERE AdminID = ?";
        //Step 3 : Execute SQL
                //NOTE: when we hard code sql, we will use $con->query()
                //when we use "?" method,use $con->prepare()
                $stmt = $con->prepare($sql);
                $stmt->bind_param('sssssssss', $fname, $email, $contact, $gender, $street, $town, $postcode, $state, $adminid);

        if ($stmt->execute()) {
                    //record edited
                    echo "<center><div><b>$adminid</b> update successful!</div></center><br>";
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
                    echo "<li>$value</li>";
                }
                echo"</ul>";
            }
        }
        ?>
        <?php
        if ($hideform == false):
            ?>
            <form action="" method="POST">
                    <table class="adminDetails"><center>
                            <tr class="adminEditTR"><span class="display">STAFF ID:</span></tr><br>
                    <tr class="adminEditTR"><center><?php
                        echo '<span  class="column2" style="cursor:no-drop;">';
                                echo $adminid;
                            echo'</span>';
                            ?></center></tr><br>
                                <input type="hidden" name="hdStaff"  value="<?php echo $adminid; ?>" />
                                <tr class="adminEditTR"><span class="display">EMAIL:</span></tr><br>
                                    <tr class="adminEditTR"><center><input type="text" name="email2" value="<?php echo $email; ?>" /></center></tr><br>
                                    <tr class="adminEditTR"><span class="display">FULL NAME:</span></tr><br>
                                        <tr class="adminEditTR"><center><input type="text" name="fname2" value="<?php echo $fname; ?>" /></center></tr><br>
                                        <tr class="adminEditTR"><span class="display">CONTACT:</span></tr><br>
                                    <tr class="adminEditTR"><center><input type="text" name="contact2" value="<?php echo $contact; ?>" /></center></tr><br>
                                    <tr class="adminEditTR"><span class="display">GENDER:</span></tr><br><br>
                                    <?php
                            $sGender = getGender(); //array
                            foreach ($sGender as $key => $value) {
                                printf("<tr class='adminEditTR'><center>%s<input type='radio' name='sgender' value='%s' %s/>
                                             </center></tr>", $value, $key, ($gender == $key) ? "checked" : "");
    }
                            ?>

                        <br><br><tr class="adminEditTR"><span class="display">STREET:</span></tr><br>
                            <tr class="adminEditTR"><center><input type="text" name="street2" value="<?php echo $street; ?>" /></center></tr><br>
                            <tr class="adminEditTR"><span class="display">TOWN/CITY:</span></tr><br>
                            <tr class="adminEditTR"><center><input type="text" name="town2" value="<?php echo $town; ?>" /></center></tr><br>
                            <tr class="adminEditTR"><span class="display">POSTCODE</span></tr><br>
                        <tr class="adminEditTR"><center><input type="text" name="postcode2" value="<?php echo $postcode; ?>" /></center></tr><br>
                            <tr class="adminEditTR"><span class="display">STATE</span></tr><br>
                            <tr class="adminEditTR"><center><select name="adminState" class="selection">
                                        <?php
                            $allState = getState(); //array
                            foreach ($allState as $key => $value) {
                                printf("
                                    <option value='%s' %s>%s</option>", $key,
                                        ($state == $key) ? "selected" : "", $value);
                            }
                            ?>


                                </select></center></tr><br>
                                </table>
                                    <center><input type="submit" class="savebtn" value="Edit" name="btnEditf" />
                                        <input type="button" value="Cancel" class="savebtn" name="btnCancel" onclick="location='adminMember.php'"/></center>
                                    </form>


    <?php
        endif;
        ?>
    </body>
</html>