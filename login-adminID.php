<?php
require_once './config/database.php';


// Check if user is already logged in
if(isset($_COOKIE['AdminID'])) {
    // User is already logged in, redirect to the homepage
    header('Location: admin-homepage.php');
    exit;
}

if(isset($_POST['btnLogin'])){
    $adminID = $_POST['txtAdminID'];
    $password = $_POST['txtPassword'];

    // Verify user credentials
    $select_query = "SELECT * FROM logina WHERE AdminID = '$adminID' AND Apassword = '$password'";
    $result = mysqli_query($con, $select_query);

    if(mysqli_num_rows($result) == 1){
        // Set the 'username' cookie variable
        setcookie('AdminID', $adminID, time() + (86400 * 30), "/");
        // Redirect to the homepage
        header('Location: admin-homepage.php');
        exit;
    }else{
        echo "<div>'Invalid username or password'</div>";
}
}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>LOGIN WITH ADMIN ID</title>
        <link href="login-adminID.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="center">
      <h1>LOGIN WITH ADMIN ID</h1>
      
      <form method="post" action="">
        <div class="txt_field">
          <input type="text" name="txtAdminID" required>
          <span></span>
          <label>Admin ID</label>
        </div>
          
        <div class="txt_field">
          <input type="password" name="txtPassword" required>
          <span></span>
          <label>Password</label>
        </div>
                  
        <input type="submit" value="Login" name="btnLogin">
        
     
      </form>
    </div>
    </body>
</html>
