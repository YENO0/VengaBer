<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>EDIT ADDRESS</title>
        <link href="css/editCust.css" rel="stylesheet" type="text/css"/>

    </head>
    <body style="background-image: url('image./background_3.jpg'); 
          background-repeat: no-repeat; background-size: cover; 
          background-position: center;">
        <?php
        require_once './config/php.php';
        include './header1.php';
        global $hideform;
        $header = array(
            'Street' => 'Street Address',
            'Town' => 'Town/City',
            'Postcode' => 'Postcode',
            'State' => 'State'
        );
        ?>
        <?php
        if (isset($_COOKIE['UserID'])) {
            $username = $_COOKIE['UserID'];
        } else {
            echo "<center><div class='msg'>You haven't Log In![<a href='login-customer.php'>LOG IN</a>]</div></center>";
        }
        ?>
        <?php
//perform "GET" function to retrieve id from url and then retrieve record from DB.dislay in the form
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //perform GET method
            //retrieve User ID from URL
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
        }
        ?>
        <?php if ($hideform == false): ?>
             <div class="dropdown">
            <button class="accBtn"><img src="images/Myaccount.png" class="logo1"/></button>
            <div class="accContent">
                <h3>My Account</h3>
                <?php
                
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

               $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

    if ($result = $con->query($sql)) {
                    if ($record = $result->fetch_object()) {
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


        <table class="editAcc">
            <tr class="trEditAcc">
            <caption><h2 class="h2acc">Delivery Address</h2></caption>
        </tr>
        <tr class="trEditAcc">
            <td><label for="editStreet" class="head">Street Address</label></td>
        </tr>
        <tr class="trEditAcc">
            <td class="coloum"> <?php
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

    if ($result = $con->query($sql)) {
                    while ($record = $result->fetch_object()) {
                        printf("
                        <tr class='acc1'>

                       <td class='column1'>%s</td>

                        </tr>
                             ", $record->Street);
    }
                }
                $result->free();
                $con->close();
                ?></td>

        </tr>
        <tr class="trEditAcc">
            <td><label for="editCity" class="head">Town/City</label></td>
        </tr>
        <tr class="trEditAcc">
            <td class="coloum"> <?php
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

    if ($result = $con->query($sql)) {
                    while ($record = $result->fetch_object()) {
                        printf("
                        <tr class='acc1'>

                       <td class='column1'>%s</td>

                        </tr>
                             ", $record->Town);
                    }
                }
                $result->free();
                $con->close();
                ?></td>
        </tr>
        <tr class="trEditAcc">
            <td><label for="editPc" class="head">Postcode</label></td>
        </tr>
        <tr class="trEditAcc">
            <td class="coloum"> <?php
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

    if ($result = $con->query($sql)) {
                    while ($record = $result->fetch_object()) {
                        printf("
                        <tr class='acc1'>

                       <td class='column1'>%s</td>

                        </tr>
                             ", $record->Postcode);
                    }
                }
                $result->free();
                $con->close();
                ?></td>
        </tr>
        <tr class="trEditAcc">
            <td><label for="editState" class="head">State</label></td>
        </tr>
        <tr class="trEditAcc">
            <td class="coloum"> <?php
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

    if ($result = $con->query($sql)) {
                    while ($record = $result->fetch_object()) {
                        printf("
                        <tr class='acc1'>

                       <td class='column1'>%s</td>

                        </tr>
                        <tr class='acc1'><td><a class='editbtn' href='edit_Add.php?username=%s'>EDIT</a></td></tr>
                             ", $record->State, $record->UserID);
            }
                }
                $result->free();
                $con->close();
                ?></td>
        </tr>

        </table>


        <?php endif; ?>
        <?php
    include './footer1.php';
    ?>
</body>
</html>