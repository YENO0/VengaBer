<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>LOGIN CUSTOMER</title>
        <link href="login-customer.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image: url('image./background_3.jpg'); 
          background-repeat: no-repeat; background-size: cover; 
          background-position: center;">
        <div class="body">
       <?php include './header1.php'; ?>
    <center>
        <table class="customer" style="margin-bottom:140px;">
            <caption><h1 style="margin-top:60px;">LOGIN CUSTOMER</h1></caption>
            <tr>
    <div class="middle">
        <td class="login1"><a class="login" href="login-username.php"><button class="btn btn1" style="margin-top:50px;">LOGIN WITH USERNAME</button></a>
          
        <div class="signup_link" style="position:relative;margin-top:5px;">
          Not a member? <a class="member" href="crtacc.php">Sign up</a>
        </div>
        
        </td>
    </div>    
        </tr>
        </table>
    </center>
  <?php include './footer1.php'; ?>
        </div>
    </body>
</html>