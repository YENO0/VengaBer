<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Footer</title>
        <link href="css/footer1.css" 
              rel="stylesheet" 
              type="text/css"/>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    </head>
    <body>
        <?php
        // Retrieve admin id and admin email from cookies
        $user_id = '';
        if(isset($_COOKIE['UserID'])){
            $user_id = $_COOKIE['UserID'];
        }
        ?>
        <footer>
            <table class="foot1">
                <tr class="foot2">
        <div class="container wrap">
            <div class="row">
                <td class="foot3">
                <div class="column">
                    <div class="footer-widget about-widget">
                        <h2 class="widget-title">About</h2>
                        <p class="title1">Step into Flower Paradise, where each bloom narrates a tale and nature's fragrance wraps you in 
                            serenity. Amidst a vibrant palette and swirling petals, moments become cherished memories. With elegance and promise, 
                            our blooms turn dreams into reality, ensuring every occasion is unforgettable. Let us be your sanctuary of beauty 
                            and joy, where the magic of flowers whispers happiness and perfection blooms in every arrangement.</p>
                    </div>
                </div>
                </td>
                <td class="foot">
                <div class="column">
                    <div class="footer-widget categories-widget">
                    <h2 class="widget-title">Categories</h2>
                    <ul class="choice1">
                        <li class="selection1"><?php
            (isset($_GET['user_id']))?
            $userID = trim($_GET['user_id']):
            $userID = "";
                echo '<a href="flowers_gypsophila.php?user_id='.$userID.'" class="link1">Gypsophila</a>'
                        ?></li>
                        <li class="selection1"><?php
            (isset($_GET['user_id']))?
            $userID = trim($_GET['user_id']):
            $userID = "";
                echo '<a href="flowers_mixedFlower.php?user_id='.$userID.'" class="link1">Mixed Flower</a>'
                        ?></li>
                        <li class="selection1"><?php
            (isset($_GET['user_id']))?
            $userID = trim($_GET['user_id']):
            $userID = "";
                echo '<a href="flowers_sunflower.php?user_id='.$userID.'" class="link1">Sunflower</a>'
                        ?></li>
                        <li class="selection1"><?php
            (isset($_GET['user_id']))?
            $userID = trim($_GET['user_id']):
            $userID = "";
                echo '<a href="flowers_tulip.php?user_id='.$userID.'" class="link1">Tulip</a>'
                        ?></li>
                        <li class="selection1"><?php
            (isset($_GET['user_id']))?
            $userID = trim($_GET['user_id']):
            $userID = "";
                echo '<a href="flowers_twistStick.php?user_id='.$userID.'" class="link1">Twist Stick</a>'
                        ?></li>
                    </ul>
                    </div>
                </div>
                </td>
                <td  class="foot">
                <div class="column">
                    <div class="footer-widget information-widget">
                    <h2 class="widget-title" style="margin-top:-80px;">Information</h2>
                    <ul class="choice1">
                        <li class="selection1"><a href="newReview2.php" class="link1">Review</a></li>
                        <li class="selection1"><a href="privacy.php" class="link1">Private Policy</a></li>
                    </ul>
                    </div>
                </div>
                </td>
                <td  class="foot">
                <div class="column">
                    <div class="footer-widget contact-widget">
                        <h2 class="widget-title">Contact</h2>
                        <div class="contact-address">
                            Address : 1670, Jalan Chow Boon Khye, Berapit, 14000 Bukit Mertajam, Pulau Pinang.
                        </div>
                        <div class="contact-number"style="color:#aba8a8;">
                            <i class="fa-solid fa-phone" style="color:#aba8a8;"></i><a href="tel:+6010-3959399" class="contact-number">Phone : +6010-3959399</a>
                        </div>
                        <div class="contact-email"style="color:#aba8a8;">
                            <i class="fa-solid fa-envelope" style="color:#aba8a8;"></i><a href="mailto:looyeeter0521@gmail.com" class="contact-email">
                                Email : looyeeter0521@gmail.com</a>
                        </div>
                    </div>
                </div>
                </td>
            </div>
        </div>
            </table>
        <div class="copyright">
            <div class="container">
                <p class="last1">Copyright @ <script type="text/javascript">document.write(new Date().getFullYear());</script> 
                    All Rights Reserved</p>
            </div>
        </div>
        </footer>
        <script src="https://kit.fontawesome.com/692d068c27.js" crossorigin="anonymous"></script>
    </body>
</html>
