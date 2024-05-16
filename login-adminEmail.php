<?php
require_once './config/database.php';


// Check if user is already logged in
if(isset($_COOKIE['Aemail'])) {
    // User is already logged in, redirect to the homepage
    header('Location: admin-homepage.php');
    exit;
}

if(isset($_POST['btnLogin'])){
    $email = $_POST['txtEmail'];
    $password = $_POST['txtPassword'];

    // Verify user credentials
    $select_query = "SELECT * FROM logina WHERE Aemail = '$email' AND Apassword = '$password'";
    $result = mysqli_query($con, $select_query);

    if(mysqli_num_rows($result) == 1){
        // Set the 'username' cookie variable
        setcookie('Aemail', $email, time() + (86400 * 30), "/");
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
        <title>LOGIN ADMIN EMAIL</title>
        <link href="login-adminEmail.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="center">
      <h1>LOGIN WITH ADMIN EMAIL</h1>
      
      <form method="post" action="">
        <div class="txt_field">
          <input type="text" name="txtEmail" required>
          <span></span>
          <label>Admin Email</label>
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
