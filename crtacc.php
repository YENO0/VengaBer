
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>WELCOME TO FLOWER PARADISE</title>
        <link rel="stylesheet" href="css/cust.css" type="text/css"/>
        <?php
        global $gender;
        
?>
    </head>
    <body style="background-image: url('image./background_3.jpg'); 
          background-repeat: no-repeat; background-size: cover; 
          background-position: center;">
        <?php
        require_once './config/php.php';
        include './header1.php';
        ?>
        <?php
        

     

        if (isset($_POST['signup'])) {
    $username = trim($_POST['user']);
    $email = trim($_POST['custemail']);
    $password = $_POST['custpass'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $rptpass = $_POST['rptpass'];
    $fname = trim($_POST['frstname']);
    $lname = trim($_POST['lstname']);
    $contact = trim($_POST['contact']);
    $street = trim($_POST['street']);
    $town = trim($_POST['town']);
    $postcode = trim($_POST['postcode']);
    $state = trim($_POST['state']);
    $securityCode = trim($_POST['securityCode']);
    isset($_POST['cGender']) ? $gender = trim($_POST['cGender']) : $gender = "";


    $msg["username"] = checkUsername($username);
    $msg["email"] = checkEmail($email);
    $msg["password"] = checkRpt($password, $rptpass);
    $msg["fname"] = checkfname($fname);
    $msg["lname"] = checklname($lname);
    $msg["contact"] = checkContact($contact);
    $msg["street"] = checkAdd($street, $town, $postcode, $state);
    $msg["securityCode"] = checkScode($securityCode);
    $msg["gender"] = checkGender($gender);


    $msg = array_filter($msg); //array_filter

    if (empty($msg) && $password === $rptpass) {
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "INSERT INTO loginc(UserID,Email,Password,Fname,Lname,Contact,Street,Town,Postcode,State,SecurityCode,Gender) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $con->prepare($sql); //$stmt = $con->prepare($sql);
        $stmt->bind_param('ssssssssssss', $username, $email, $password, $fname, $lname, $contact, $street, $town, $postcode, $state, $securityCode, $gender);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            //record inserted
            echo "<div> Your account<b>$username</b> has been created!</div>";
            //reset field
            $username = $email = $password = $fname = $lname = $contact = $street = $town = $postcode = $state = $securityCode = $gender = null;
        }else {
//record unable to insert
            echo "<div class='msg'>Unable to insert.Please try again !</div>";
        }
$stmt->close();
$con->close();
}
 else {
        
        
        foreach ($msg as $value) {
           
            echo "<p class=msg>*$value</p>";
            
        }

        
    }
}
?>





        <form class="suf" action="" method="POST">

            <div class="set">
                <div class="animationHeader">
                    <h1 style="text-align: center;"><div class="animationHeader"><span>S</span><span>I</span><span>G</span><span>N</span> <span>U</span><span>P</span> <span>A</span><span>S</span> <span>A</span> <span>F</span><span>L</span><span>O</span><span>W</span><span>E</span><span>R</span> <span>P</span><span>A</span><span>R</span><span>A</span><span>D</span><span>I</span><span>S</span><span>E</span> <span>M</span><span>E</span><span>M</span><span>B</span><span>E</span><span>R</span></div></h1>
                    <p style="text-align: center; font-size:18px;">Create your profile and get access to the Flower Paradise flowers</p>
                    <hr>
                    <label for="user" class="headinput">Username</label><br/>
                    <center><input type="text" name="user" placeholder="USERNAME" value="<?php
                        echo (isset($username)) ? $username : "";
                        ?>"/></center>
                    <br/>
                    <label for="custemail" class="headinput">Email Address</label><br/>
                    <center><input type="text" name="custemail" placeholder="EMAIL ADDRESS"value="<?php
                        echo (isset($email)) ? $email : "";
                        ?>"/></center>
                    <br/>
                    <label for="custpass" class="headinput">Password</label><br/>
                    <center><input type="password" name="custpass" placeholder="PASSWORD"/></center>
                    <br/>
                    <label for="rptpass" class="headinput">Confirm Password</label><br/>
                    <center><input type="password" name="rptpass" placeholder="REPEAT PASSWORD"/></center>
                    <br/>
                    <label for="frstname" class="headinput">First Name</label><br/>
                    <center><input type="text" name="frstname" placeholder="FIRST NAME" value="<?php
                        echo (isset($fname)) ? $fname : "";
                        ?>"/></center>
                    <br/>
                    <label for="lstname" class="headinput">Last Name</label><br/>
                    <center><input type="text" name="lstname" placeholder="LAST NAME" value="<?php
                        echo (isset($lname)) ? $lname : "";
                        ?>"/></center>
                    <br/>
                    <label for="contact" class="headinput">Contact Number</label><br/>
                    <center><input type="text" name="contact" placeholder="CONTACT NUMBER"value="<?php
                        echo (isset($contact)) ? $contact : "";
                        ?>"/></center>
                    <br/>
                    <label for="contact" class="headinput">Street</label><br/>
                    <center><input type="text" name="street" value="<?php
                        echo (isset($street)) ? $street : "";
                        ?>"/></center>
                    <br/>
                    <label for="contact" class="headinput">Town/City</label><br/>
                    <center><input type="text" name="town" value="<?php
                        echo (isset($town)) ? $town : "";
                        ?>"/></center>
                    <br/>
                    <label for="contact" class="headinput">Postcode</label><br/>
                    <center><input type="text" name="postcode"value="<?php
                        echo (isset($postcode)) ? $postcode : "";
                        ?>"/></center>
                    <br/>
                    <label for="state" class="headinput">State</label><br/>
                    <center>            <select name="state" class="cstate">
                            <?php
                            $allState = getState(); //array
                            foreach ($allState as $key => $value) {
                                printf("<option value='%s' %s>%s</option>", $key
                                        , ($state == $key) ? "selected" : ""
                                        , $value);
                            }
                            ?>
                        </select></center>
                    <br/>
                    <label for="securityCode" class="headinput">Security Code</label><br/>
                    <center><input type="text" name="securityCode"value="<?php
                        echo (isset($securityCode)) ? $securityCode : "";
                        ?>"/></center>
                    <br/>
                    <center>
                        <?php
                        $aGender = getGender(); //array
                        foreach ($aGender as $key => $value) {
                            printf("<input type='radio' name='cGender' value='%s' %s/>%s
                                             ", $key, ($gender == $key) ? "checked" : "", $value);
                        }
                        ?>
                        <br/>
                        <input type="checkbox" id='agree' name="agree" required />
                        <label for="agree">By creating an account,you agree to Flower Paradise <a href="privacy.php"  class="pri">privacy policy</a></label>
                        <br/>
                        <input type="submit" value="JOIN NOW" name="signup"/></center>

                </div>
        </form>

        <?php
        include './footer1.php';
        ?>
    </body>
</html>
