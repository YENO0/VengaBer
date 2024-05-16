<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <?php
        global $gender;
        
        ?>
        <meta charset="UTF-8">
        <title></title>
        <link href="css/adminAcc.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image: url(images/3.jpg);background-size: cover;background-repeat: no-repeat;">
        <?php
        require_once './config/php.php';
        include './adminHeader1.php';
        ?>
        <?php
        if (isset($_POST['signup'])) {
            $adminid = trim($_POST['adminID']);
            $fname = trim($_POST["adminName"]);
    $email = trim($_POST['adminEmail']);
            $password = $_POST['adminPassword'];
            $rptpass = $_POST['adminRptPass'];
    $contact = trim($_POST['adminContact']);
            $street = trim($_POST['adminStreet']);
            $town = trim($_POST['adminTown']);
            $postcode = trim($_POST['adminPcode']);
            $state = trim($_POST['adminState']);
            isset($_POST['sgender']) ? $gender = trim($_POST['sgender']) : $gender = "";

    $msg["adminid"] = checkAdminID($adminid);
    $msg["fname"] = checkfname($fname);
    $msg["email"] = checkEmail($email);
    $msg["password"] = checkRpt($password, $rptpass);
    $msg["contact"] = checkContact($contact);
    $msg["gender"] = checkGender($gender);
    $msg["street"] = checkAdd($street, $town, $postcode, $state);

    $msg = array_filter($msg);

            if (empty($msg) && $password === $rptpass) {
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $sql = "INSERT INTO logina(AdminID,Aname,Aemail,Acontact,Apassword,Agender,Astreet,ATown,APostcode,AState) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $stmt = $con->prepare($sql);
                $stmt->bind_param('ssssssssss', $adminid, $fname, $email, $contact, $password, $gender, $street, $town, $postcode, $state);

        $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    //record inserted
                    echo "<div> Your account<b>$adminid</b> has been created!</div>";
            //reset field
                    $adminid = $fname = $email = $password = $contact = $gender = $street = $town = $postcode = $state = null;
        } else {
//record unable to insert
                    echo "<div class='msg'>Unable to insert.Please try again !</div>";
                }
                $stmt->close();
                $con->close();
            } else {


                foreach ($msg as $value) {

                    echo "<p class=msg>*$value</p>";
                }
            }
        }
        ?>
    <center><h1 style="color:black;">SIGN UP  YOUR ACCOUNT</h1></center>

    <form action=""  method="POST" class="adminAcc">
        <center>
            <label for="adminID" class="head">ADMIN ID</label><br/>
            <input type="text" name="adminID"  value="<?php
            echo (isset($adminid)) ? $adminid : "";
            ?>" /><br/>
            <label for="adminName" class="head">FULL NAME</label><br/>
            <input type="text" name="adminName" value="<?php
            echo (isset($fname)) ? $fname : "";
            ?>"/>
            <br/>
            <label for="adminEmail" class="head">EMAIL ADDRESS</label><br/>
            <input type="text" name="adminEmail"  value="<?php
            echo (isset($email)) ? $email : "";
            ?>"/><br/>
            <label for="adminContact" class="head">CONTACT NUMBER</label><br/>
            <input type="text" name="adminContact"  value="<?php
            echo (isset($contact)) ? $contact : "";
            ?>" />            <br/>
            <label for="adminPassword" class="head">PASSWORD</label><br/>
            <input type="password" name="adminPassword" value="" /><br/>
            <label for="adminRptPass" class="head">REPEAT PASSWORD</label><br/>
            <input type="password" name="adminRptPass" value="" /><br/>
            <label for="sgender" class="head">GENDER</label><br/><br/>
            <?php
            $sGender = getGender(); //array
            foreach ($sGender as $key => $value) {
                printf("<input type='radio' name='sgender' value='%s' %s/>%s
                                             ", $key, ($gender == $key) ? "checked" : "", $value);
            }
            ?>
            <br/>
            <br/>
            <h4 class="head">HOME ADDRESS</h4>
            <hr/>
            <label for="adminStreet" class="head" class="head">STREET ADDRESS</label><br/>
            <input type="text" name="adminStreet"  value="<?php
            echo (isset($street)) ? $street : "";
            ?>"/><br/>
            <label for="adminTown" class="head">TOWN/CITY</label><br/>
            <input type="text" name="adminTown"  value="<?php
            echo (isset($town)) ? $town : "";
            ?>" /><br/>
            <label for="adminPcode" class="head">POSTCODE</label><br/>
            <input type="text" name="adminPcode"  value="<?php
            echo (isset($postcode)) ? $postcode : "";
            ?>" /><br/>
            <label for="adminState" class="head">STATE</label><br/>
            <select name="adminState">
                <?php
                $allState = getState(); //array
                foreach ($allState as $key => $value) {
                    printf("<option value='%s' %s>%s</option>", $key
                            , ($state == $key) ? "selected" : ""
                            , $value);
                }
                ?>
            </select>
            <br/>
            <input type="submit" name="signup" value="Create" />
        </center>

    </form>

</body>
</html>
