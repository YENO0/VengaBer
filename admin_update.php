<?php

@include './config/config.php';
$id = $_GET['edit'];
if(isset($_POST['update_product'])){
    
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
        $message[]='please fill out all';
    } else {
        $update = "UPDATE products SET categories='$product_categories', name='$product_name', price='$product_price', description='$product_description', image1='$product_image1', image2='$product_image2', image3='$product_image3' WHERE id = $id";
        $upload = mysqli_query($conn, $update);
        if($upload){
            move_uploaded_file($product_image_tmp_name1, $product_image_folder1);
            move_uploaded_file($product_image_tmp_name2, $product_image_folder2);
            move_uploaded_file($product_image_tmp_name3, $product_image_folder3);
            $message[]= 'new product added successfully';
        } else {
            $message[]= 'could not add the product';
        }
    }
    header('location:list_product.php');
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
        <title>update product page</title>
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
        if (isset($message)) {
            foreach ($message as $message) {
                echo '<span class="message">' . $message . '</span>';
            }
        }
        ?>

        <div class="container">

            <div class="admin-product-form-container centered">

                <?php
                $id = $_GET['edit'];
                $select = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
                while ($row = mysqli_fetch_assoc($select)) {
                    ?>

                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                        <h3>update the product</h3>
                        <div class="form_title">Update Product Categories:</div>
                        <input type="text" placeholder="enter product categories" value="<?php printf("%s", $row['categories']); ?>" name="product_categories" class="box">
                        <div class="form_title">Update Product Name:</div>
                        <input type="text" placeholder="enter product name" value="<?php printf("%s", $row['name']); ?>" name="product_name" class="box">
                        <div class="form_title">Update Product Price:</div>
                        <input type="number" placeholder="enter product price" value="<?php printf("%s", $row['price']); ?>" name="product_price" class="box">
                        <div class="form_title">Update Product Description:</div>
                        <input type="text" placeholder="enter product description" value="<?php printf("%s", $row['description']); ?>" name="product_description" class="box">
                        <div class="form_title">Update Product Image:</div>
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image1" class="box">
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image2" class="box">
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image3" class="box">
                        <input type="submit" class="btn" name="update_product" value="update product">
                        <a href="list_product.php" class="btn">go back</a>
                    </form>
                    <?php
                    $conn->close();
                };
                ?>
            </div>
        </div>
    </body>
</html>
