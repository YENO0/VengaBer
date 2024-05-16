<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <?php global $hideform;
        global $dbpass;
        ?>
        <link href="css/adminEdit.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image: url(images/3.jpg);background-size: cover;background-repeat: no-repeat;">
        <?php
        include './adminHeader1.php';
        require_once './config/php.php';
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
        echo "<center><div class='msg'>No record found![<a href='admin-homepage.php'>Back to home</a>]</div></center>";
        $hideform = true;
        }
        $con->close();
        $result->free();
        } else {
        //perform POST method
        //hint:very similar to insert  function
        //retrieve  input from user
    $adminid = strtoupper(trim($_POST["hdStaff2"]));
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
        $sql = "UPDATE logina SET Apassword=? WHERE AdminID = ?";
        //Step 3 : Execute SQL
        //NOTE: when we hard code sql, we will use $con->query()
        //when we use "?" method,use $con->prepare()
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ss', $npassword, $adminid);

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
                    <input type="hidden" name="hdStaff2" value="<?php echo $adminid; ?>" />

                <tr class="trpass">
                <caption><h2 class="h2acc">Change Password</h2></caption>
                </tr>
                <tr class="trpass">
                    <td class="customiao"><label for="currentP" class="head">Current Password</label></td>
                </tr>
                <tr class="trpass">
                        <td><input type="password" name="currentP" value="" /></td>

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
                        <td><input type="button" value="Cancel" class="cancelbtn" name="btnCancel" onclick="location='adminMember.php'"/></td>
                        </tr>

                </table>
            </form>
        <?php endif; ?>
    </body>
</html>