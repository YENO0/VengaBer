<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Header</title>
        <link href="css/adminHeader1.css" 
              rel="stylesheet" 
              type="text/css"/>
    </head>
    <body>
         <?php
        $admin_id = '';
        $admin_email = '';
        if(isset($_COOKIE['AdminID'])){
            $admin_id = $_COOKIE['AdminID'];
        }
        if(isset($_COOKIE['Aemail'])){
            $admin_email = $_COOKIE['Aemail'];
        }
        ?>

        
        <nav class="header_title">
            <div style='width: 30%; float: left;'><a href="admin-homepage.php" class="header_logo">Flower Paradise</a></div>
            
            <div style='width: 100%; padding-top: 30px;'>
            <ul class="header_ul">
                <li class="header_li"><a href="adminMember.php" class="header_a">Account</a></li>
                
                <div class="dropdowns">
                <button class="dropbtn">Review <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-content">
                <a href="admin_review.php" class="admin_a">View Review</a>
                <a href="list_review.php" class="admin_a">List of Review</a>
                </div>
                </div>
                
                <div class="dropdowns">
                <button class="dropbtn">Flowers <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-content">
                <a href="admin_page.php" class="admin_a">Add Flower</a>
                <a href="list_product.php" class="admin_a">List of Flowers</a>
                </div>
                </div>

                <li class="header_li"><a href="adminorder.php" class="header_a">Order</a></li>
                 <?php
                // Check if the session variable is set
                if (isset($_COOKIE['Aemail'])||($_COOKIE['AdminID'])) {
                // if the session variable dont have, show the logout button
                echo "<li class='header_li'><a href='logout-admin.php' class='header_a'>LOG OUT</a></li>";
                } else {}
            ?>
                <li class="header_li"><a href="admin.php" class="header_a">Sign Up</a></li>
            </ul>
                </div>
        </nav>
        <section></section>
        <script src="https://kit.fontawesome.com/692d068c27.js" crossorigin="anonymous"></script>
    </body>
</html>
















