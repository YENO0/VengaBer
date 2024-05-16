<?php
@session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Header</title>
        <link href="css/header1.css" 
              rel="stylesheet" 
              type="text/css"/>
    </head>
    <body>
        <?php
        // Retrieve admin id and admin email from cookies
        $user_id = '';
        if(isset($_COOKIE['UserID'])){
            $user_id = $_COOKIE['UserID'];
        }
        ?>
        <div style="display: flex;" class="header_title">
            <?php
            (isset($_GET['user_id']))?
            $userID = trim($_GET['user_id']):
            $userID = "";
            echo "<div style='width: 30%; float: left;'><a href='homepage.php?user_id=$userID' class='header_logo'>Flower Paradise</a></div>";
            ?>
            <div style='width: 70%; padding-top: 60px;'>
            <ul class="header_ul">
                
                <li class="header_li"><a href="editAcc.php?user_id=<?php echo $user_id?>" class="header_a">Profile</a></li>
                <div class="dropdowns">
                <button class="dropbtn header_li">Flowers <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-content">
                <?php
                (isset($_GET['user_id']))?
                $userID = trim($_GET['user_id']):
                $userID = "";
                echo "<a href='flowers_gypsophila.php?user_id=$userID' class='admin_a'>Gypsophila</a>
                <a href='flowers_mixedFlower.php?user_id=$userID' class='admin_a'>Mixed Flower</a>
                <a href='flowers_sunflower.php?user_id=$userID' class='admin_a'>Sunflower</a>
                <a href='flowers_tulip.php?user_id=$userID' class='admin_a'>Tulip</a>
                <a href='flowers_twistStick.php?user_id=$userID' class='admin_a'>Twist Stick</a>";
                ?>
                </div>
                </div>
                <li class="header_li"><a href="custorder.php?user_id=<?php echo $user_id?>" class="header_a">Order</a></li>
                <li class="header_li"><a href="cart.php?user_id=<?php echo $user_id?>" class="header_a">Cart</a></li>
                <li class="header_li"><a href="newReview2.php?user_id=<?php echo $user_id?>" class="header_a">Review</a></li>

                <?php
            // Check if the session variable is set
            if (isset($_COOKIE['UserID'])) {
                // if the session variable dont have, show the logout button
                echo "<li class='header_li'><a href='logout-customer.php' class='header_a'>LOG OUT</a></li>";
            } else { 
                echo "<li class='header_li'><a href='login-customer.php' class='header_a'>LOG IN</a></li>";
            }
            ?>
                
            <?php
            // Check if the session variable is set
            if (isset($_COOKIE['UserID'])) {
            } else { 
                echo "<li class='header_li'><a href='crtacc.php' class='header_a'>SIGN UP</a></li>";
            }
            ?>

            </ul>
                </div>
        </div>
        <section></section>
        <script src="https://kit.fontawesome.com/692d068c27.js" crossorigin="anonymous"></script>
    </body>
</html>