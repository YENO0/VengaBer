<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gypsophila</title>
        <link href="css/category.css" 
              rel="stylesheet" 
              type="text/css"/>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.1.8.3.min.js"></script>
        <script src="js/site.js"></script>
        <link href="css/animate.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image: url('image./background_3.jpg'); 
          background-repeat: no-repeat; background-size: cover; 
          background-position: center;">
        <?php include './header1.php'; ?>
        <table class="product2">
            <form method="post" action="">
                <?php 
define('DB_HOST', "yy-ver1-rds.ctqigw62kpxk.us-east-1.rds.amazonaws.com");
                define('DB_USER', "yen0809");
                define('DB_PASS', "p3TEr100");
                define('DB_NAME', "PETER");
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


$sql = "SELECT * FROM products WHERE categories = 'gypsophila'";
if($result = $con->query($sql)){
                while($record = $result->fetch_object()){
                    (isset($_GET['user_id']))?
                    $userID = trim($_GET['user_id']):
                    $userID = "";
                        printf("
                        <table class='product2 wow fadeInUp' style='width: 650px; height: 500px;'>
                        <tr class='tr1'>
                        <td class='td2'><center><a href='gypsophila.php?id=%d&user_id=%s'><img src='uploaded_img/%s' height='350' alt='' class='product_img'></a></center></td>
                        </tr>
                        <tr class='tr1'>
                        <td class='td1'>%s<br/><br/>
                        <b style='font-size: 25px;'>RM %s.00</b>
                        <br/><br/><a href='gypsophila.php?id=%d&user_id=%s' class='product1'>View More Details &#128073; </a></td>
                        <br/>
                        </tr>
                        </table>

                            ",$record->id,
                              $userID,
                              $record->image1,
                              $record->name,
                              $record->price,
                              $record->id,
                              $userID);
                }
            } 
            $result->free();
            $con->close();
?>
        
            </form>
        </table>
    </body>
    <?php include './footer1.php'?>
</html>