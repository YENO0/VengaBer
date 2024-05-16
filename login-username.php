<?php
require_once './config/database.php';


// Check if user is already logged in
if(isset($_COOKIE['UserID'])) {
    // User is already logged in, redirect to the homepage
    $username = $_POST['txtUsername'];
    printf("header('Location: homepage.php?user_id=%s');",$username);
    exit;
}

if(isset($_POST['btnLogin'])){
    $username = $_POST['txtUsername'];
    $password = $_POST['txtPassword'];

    // Verify user credentials
    $select_query = "SELECT * FROM loginc WHERE UserID = '$username' AND Password = '$password'";
    $result = mysqli_query($con, $select_query);

    if(mysqli_num_rows($result) == 1){
        // Set the 'username' cookie variable
        setcookie('UserID', $username, time() + (86400 * 30), "/");
        // Redirect to the homepage
        header("Location: homepage.php?user_id=" . $username);
        exit;
    }else{
        echo "<script>alert('Invalid username or password')</script>";
}
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>LOGIN USERNAME</title>
        <link href="login-username.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image: url('image./background_3.jpg'); 
          background-repeat: no-repeat; background-size: cover; 
          background-position: center;">
        <?php include './header1.php'; ?>
        <div class="body">
        <div class="center" >
      <h1>LOGIN WITH USERNAME</h1>
      
      <form method="post" action="">
        <div class="txt_field">
          <input type="text" id="txtUsername" name="txtUsername" required>
          <span></span>
          <label>Username</label>
        </div>
          
        <div class="txt_field">
          <input type="password" id="txtPassword" name="txtPassword" required>
          <span></span>
          <label>Password</label>
        </div>
          
        <div class="pass"><a href="forgot-passwordCustomer.php">Forgot Password?</a></div>
        
         
        <input type="submit" value="Login" name="btnLogin">
        
        <div class="signup_link">
          Not a member? <a href="crtacc.php">Sign up</a>
        </div>
      </form>
    </div>
            </div>
        <div class="footer">
          <?php include './footer1.php'; ?>
        </div>
    </body>
</html>