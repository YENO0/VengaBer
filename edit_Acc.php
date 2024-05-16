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
        <title>EDIT ACCOUNT</title>
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
    $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

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
        $gender = $record->Gender;
        $street = $record->Street;
        $town = $record->Town;
        $postcode = $record->Postcode;
        $state = $record->State;
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
    $username = strtoupper(trim($_POST["hdUser"]));
    $email = trim($_POST["email1"]);
            $fname = trim($_POST["fname1"]);
            $lname = trim($_POST["lname1"]);
            $contact = trim($_POST["phone1"]);
            $gender = trim($_POST["Gender"]);

    //validation all input from helper.php
    $msg["email"] = editEmail($email);
    $msg["fname"] = checkfname($fname);
    $msg["lname"] = checklname($lname);
            $msg["contact"] = checkContact($contact);
            $msg["gender"] = checkGender($gender);

            //remove null error
    $msg = array_filter($msg);

    if (empty($msg)) {
                //no error,can UPDATE record
        //Step 1:Establish connection
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        //Step 2 :SQL Statement
        $sql = "UPDATE loginc SET Email = ?,Fname=?,Lname=?,Contact=?,Gender=? WHERE UserID = ?";
        //Step 3 : Execute SQL
        //NOTE: when we hard code sql, we will use $con->query()
        //when we use "?" method,use $con->prepare()
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ssssss', $email, $fname, $lname, $contact, $gender, $username);

            if ($stmt->execute()) {
            //record edited
            echo "<center><div><b>$username</b> update successful!</div></center><br>";
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
    if($hideform==false):
    ?>
    <form action="" method="POST" style="margin-left: 470px;">
            <table class="divedit">
                <tr class="editTr"><b>Username:</b></tr><br>
                <tr class="editTr"><?php
                    echo '<span  class="column1" style="cursor:no-drop;">';
                        echo $username;
                    echo'</span>';
                    ?></tr><br>
                    <input type="hidden" name="hdUser"  value="<?php echo $username; ?>" />
                        <tr class="editTr"><b>Email:</b></tr><br>
    <tr class="editTr"><input type="text" id="email1"  class="column2" name="email1" value="<?php echo $email; ?>"></tr><br>
        <tr class="editTr"><b>First Name:</b></tr><br>
    <tr class="editTr"><input type="text" id="fname1" class="column2" name="fname1" value="<?php echo $fname; ?>"></tr><br>
        <tr class="editTr"><b>Last Name:</b></tr><br>
    <tr class="editTr"><input type="text" id=lname1" class="column2" name="lname1" value="<?php echo $lname; ?>"></tr><br>
        <tr class="editTr"><b>Contact No:</b></tr><br>
    <tr class="editTr"><input type="text" id="phone1" class="column2" name="phone1" value="<?php echo $contact; ?>"></tr><br>
        <tr class="editTr"><b>Gender:</b></tr><br>
                <?php
                    $eGender = getGender(); //array
                    foreach ($eGender as $key => $value) {
                        printf("<tr class='editTr'>%s<input type='radio' name='Gender' value='%s' %s/>
                                             </tr>", $value, $key, ($gender == $key) ? "checked" : "");
                }
                    ?>
                </table>
                <br>
                <input type="submit" class="editbtn" value="Edit" name="btnEditf" />
                <input type="button" value="Cancel" class="editbtn" name="btnCancel" onclick="location='editAcc.php'"/>


        </form>

        <?php endif;
        ?>
        <?php
        include './footer1.php';
        ?>
    </body>
</html>