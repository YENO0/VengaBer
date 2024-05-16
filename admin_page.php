<?php
require_once './config/config.php';

if(isset($_POST['add_product'])){
    $product_categories = $_POST['product_categories'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_description = $_POST['product_description'];
    $product_image1 = $_FILES['product_image1']['name'];
    $product_image2 = $_FILES['product_image2']['name'];
    $product_image3 = $_FILES['product_image3']['name'];
    $product_image_tmp_name1 = $_FILES['product_image1']['tmp_name'];
    $product_image_tmp_name2 = $_FILES['product_image2']['tmp_name'];
    $product_image_tmp_name3 = $_FILES['product_image3']['tmp_name'];
    $product_image_folder1 = 'uploaded_img/'.$product_image1;
    $product_image_folder2 = 'uploaded_img/'.$product_image2;
    $product_image_folder3 = 'uploaded_img/'.$product_image3;
    
    if(empty($product_categories) || empty($product_name) || empty($product_price) || empty($product_description) || empty($product_image1)) {
        $message[]='Please Enter Product <b>IMAGE</b>';
    } else {
        $insert = "INSERT INTO products(categories, name, price, description, image1, image2, image3) VALUES('$product_categories', '$product_name', '$product_price', '$product_description', '$product_image1', '$product_image2', '$product_image3')";
        $upload = mysqli_query($conn, $insert);
        if($upload){
            move_uploaded_file($product_image_tmp_name1, $product_image_folder1);
            move_uploaded_file($product_image_tmp_name2, $product_image_folder2);
            move_uploaded_file($product_image_tmp_name3, $product_image_folder3);
            $message[]= 'new product added successfully';
        } else {
            $message[]= 'could not add the product';
        }
    }
};
$conn->close();
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
        <title>Admin Product</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="css/style.css" 
              rel="stylesheet" 
              type="text/css"/>
    </head>
    <body style="background-image:url(images/3.jpg);background-size: cover;background-repeat: no-repeat;">
        <?php
        include './adminHeader1.php';
        ?>
        
        <?php 
        if(!empty($_POST)){
            //user clicked or entered data into insert form
            //retrieve input from the user
            $categories = trim($_POST['product_categories']); 
            $name = trim($_POST['product_name']);
            $price = trim($_POST['product_price']); 
            $description = trim($_POST['product_description']);
            
            //validation all input from helper.php
            $error["categories"] = checkCategories($categories);
            $error["name"] = checkProductName($name);
            $error["price"] = checkPrice($price);
            $error["description"] = checkDescription($description);
            
            //remove null error
            $error = array_filter($error);
            
            //check if $error contains msg?
           
                //NOT GOOD, with error, display error
                echo "<ul class='message'>";
                foreach ($error as $value){
                    echo"<li class='message_li'>$value</li>";
                }
                foreach ($message as $value){
                    echo"<li class='message_li'>$value</li>";
                }
                echo "</ul>";
            
            
        }
        ?>
        <div class="container">
            <div class="admin-product-form-container">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>add a new flower</h3>
                    <div class="form_title">Enter Flower Categories:</div>
                    <input type="text" placeholder="Enter Flower Categories" name="product_categories" class="box" value="<?php
                    echo (isset($categories))? $categories : "";
                    ?>" />
                    <div class="form_title">Enter Flower Name:</div>
                    <input type="text" placeholder="Enter Flower Name" name="product_name" class="box" value="<?php
                    echo (isset($name))? $name : "";
                    ?>" />
                    <div class="form_title">Enter Flower Price:</div>
                    <input type="number" placeholder="Enter Flower Price" name="product_price" min="1" class="box" value="<?php
                    echo (isset($price))? $price : "";
                    ?>" />
                    <div class="form_title">Enter Flower Description:</div>
                    <input type="text" placeholder="Enter Flower Description" name="product_description" class="box" value="<?php
                    echo (isset($description))? $description : "";
                    ?>" />
                    <div class="form_title">Enter Flower Image:</div>
                    <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image1" class="box" />
                    <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image2" class="box" />
                    <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image3" class="box" />
                    <input type="submit" class="btn" name="add_product" value="add flower" />
                            </form>

            </div>
        </div>
    </body>
</html>