<?php
define('DB_HOST', "yy-ver1-rds.ctqigw62kpxk.us-east-1.rds.amazonaws.com");
define('DB_USER', "yen0809");
define('DB_PASS', "p3TEr100");
define('DB_NAME', "PETER");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$id = $_GET['edit'];

if(isset($_POST['update_product'])){
    $new_rating = $_POST['new_rating'];
    $new_name = $_POST['new_name'];
    $new_comment = $_POST['new_comment'];
    
    if(empty($new_rating) || empty($new_name) || empty($new_comment)) {
        $message[]='please fill out all';
    } else {
        $update = "UPDATE review_table SET user_rating='$new_rating', user_name='$new_name', user_review='$new_comment' WHERE review_id = $id";
        $upload = mysqli_query($con, $update);
        if($upload){
            $message[]= 'new product added successfully';
        } else {
            $message[]= 'could not add the product';
        }
    }
    header('location:list_review.php');
};
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale="1.0">
        <title>update review page</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="css/style.css" 
              rel="stylesheet" 
              type="text/css"/>
    </head>
    <body style="background-image:url(images/3.jpg);background-size: cover;background-repeat: no-repeat;">
        <?php
        include './adminHeader1.php';
        ?>
        
        <div class="container">
            
            <div class="admin-product-form-container centered">
                
                <?php
                $select = mysqli_query($con, "SELECT * FROM review_table WHERE review_id = $id");
                while($row = mysqli_fetch_assoc($select)){
                ?>
                
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>update the review</h3>
                    <div class="form_title">Update New Rating:</div>
                    <input type="number" placeholder="enter new rating (1-5)" value="<?php printf("%s",$row['user_rating']); ?>" name="new_rating" class="box" min='1' max='5'>
                    <div class="form_title">Update New Name:</div>
                    <input type="text" placeholder="enter new name" value="<?php printf("%s",$row['user_name']); ?>" name="new_name" class="box">
                    <div class="form_title">Update New Comment:</div>
                    <input type="text" placeholder="enter new comment" value="<?php printf("%s",$row['user_review']); ?>" name="new_comment" class="box">
                    <a href="list_review.php"><input type="submit" class="btn" name="update_product" value="update review"></a>
                    <a href="list_review.php" class="btn">go back</a>
                </form>
                <?php 
                $con->close();
                }; ?>
            </div>
        </div>
    </body>
</html>
