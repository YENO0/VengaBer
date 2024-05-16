<?php
require_once './config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['txtEmail'];
    $security_code = $_POST['txtSecurityCode'];
    $new_password = $_POST['txtNewPassword'];
    $confirm_password = $_POST['txtConfirmPassword'];

    // validate email and security code
    $query = "SELECT * FROM loginc WHERE email = '$email' AND SecurityCode = '$security_code'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // email and security code match

        // validate new password and confirm password
        if ($new_password == $confirm_password) {
            // update password in the database
            $query = "UPDATE loginc SET Password = '$new_password' WHERE email = '$email'";
            mysqli_query($con, $query);

            // redirect to login page
            header('Location: login-customer.php');
            exit;
        } else {
            // new password and confirm password do not match
            echo "<div>New password and confirm password do not match.</div>";
        }
    } else {
        // email and security code do not match
        echo "<div>Email and security code do not match.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FORGOT PASSWORD</title>
    <link href="forgot-passwordCustomer.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php include './header1.php'; ?>
    <div class="body">
    <div class="center">
        <h1>FORGET PASSWORD RECOVERY</h1>
      
        <form method="post" action="">
            <div class="txt_field">
                <input type="text" name="txtEmail" required>
                <span></span>
                <label>Email</label>
            </div>
          
            <div class="txt_field">
                <input type="text" name="txtSecurityCode" required>
                <span></span>
                <label>Security Code</label>
            </div>
          
            <div class="txt_field">
                <input type="password" name="txtNewPassword" required>
                <span></span>
                <label>New password</label>
            </div>
          
            <div class="txt_field">
                <input type="password" name="txtConfirmPassword" required>
                <span></span>
                <label>Confirm Password</label>
            </div>
           
            <input type="submit" value="Proceed" name="btnLogin">
        </form>
    </div>
    </div>
    <div class="footer">
    <?php include './footer1.php'; ?>
    </div>
    </body>
</html>
