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
        <title>EDIT ADDRESS</title>
    </head>
    <link href="css/editCust.css" rel="stylesheet" type="text/css"/>
    <body style="background-image:url(image/background_1.jpg);
                 background-repeat:no-repeat;
                 background-size:cover;">
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
    <center><h2>Edit Profile</h2></center>
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
    } else {
        //perform POST method
        //hint:very similar to insert  function
        //retrieve  input from user
    $username = strtoupper(trim($_POST["hdUser1"]));
    $street = trim($_POST["street1"]);
    $town = trim($_POST["town1"]);
    $postcode = trim($_POST["pcd1"]);
    $state = trim($_POST["state1"]);

    $msg["street"] = checkAdd($street, $town, $postcode, $state);
//remove null error
        $msg = array_filter($msg);

        if (empty($msg)) {
            //no error,can UPDATE record
            //Step 1:Establish connection
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            //Step 2 :SQL Statement
            $sql = "UPDATE Loginc SET Street = ?,Town = ?,Postcode=?,State=? WHERE UserID = ?";
        //Step 3 : Execute SQL
            //NOTE: when we hard code sql, we will use $con->query()
            //when we use "?" method,use $con->prepare()
            $stmt = $con->prepare($sql);
            $stmt->bind_param('sssss', $street, $town, $postcode, $state, $username);

        if ($stmt->execute()) {
                //record edited
                echo "<center><div>Address update successful!</div></center><br>";
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
        <form action="" method="POST" style="margin-left: 470px;">
            <table class="divedit">
                    <input type="hidden" name="hdUser1" value="<?php echo $username; ?>" />
                    <tr class="editTr"><b>Street/Address:</b></tr><br>
                <tr class="editTr"><input type="text" id="street1" class="column2" name="street1" value="<?php echo $street; ?>"></tr><br>
                <tr class="editTr"><b>Town/City:</b></tr><br>
            <tr class="editTr"><input type="text" id="town1" class="column2" name="town1" value="<?php echo $town; ?>"></tr><br>
                    <tr class="editTr"><b>Postcode:</b></tr><br>
                    <tr class="editTr"><input type="text" id=pcd1" class="column2" name="pcd1" value="<?php echo $postcode; ?>"></tr><br>
                    <tr class="editTr"><b>State:</b></tr><br>
        <tr class="editTr"><select class="column3" name="state1">
                <?php
                            $allState = getState(); //array
                            foreach ($allState as $key => $value) {
                                printf("
                                    <option value='%s' %s>%s</option>", $key,
                                        ($state == $key) ? "selected" : "", $value);
                            }
                            ?>


                        </select></tr><br>
                </table>
            <br>
            <input type="submit" class="editbtn" value="Edit" name="btnEditA" />
                <?php
               
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                $sql = "SELECT * FROM Loginc";

                if ($result = $con->query($sql)) {
                    if ($record = $result->fetch_object()) {
                        printf("

                <button class='editbtn'><a href='editAdd.php?username=%s' class='content' style='color:white';>Cancel</a></button>
                             ", $record->UserID);
                    }
                }
                $result->free();
                $con->close();
                ?>


        </form>

    <?php endif;
    ?>
    <?php
    include './footer1.php';
    ?>
</body>
</html>