<?php
@include './config/config.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete related records from the cart table
    mysqli_query($conn, "DELETE FROM cart WHERE ID = $id");

    // Now, delete the product from the products table
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");

    header('location:list_product.php');
}
;

?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>List Flower</title>
        <link href="css/style.css" 
              rel="stylesheet" 
              type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>
    <body style="background-image:url(images/3.jpg);background-size: cover;background-repeat: no-repeat;">
        <?php
        include './adminHeader1.php';
        
        $header = array(
            'image1' => 'Flower Image',
            'categories' => 'Flower Categories',
            'name' => 'Flower Name',
            'price'  => 'Flower Price',
            'description'  => 'Flower Description'
        );
            
            global $sort, $order;
        if (isset($_GET['sort']) && isset($_GET['order'])){
        $sort = (array_key_exists($_GET['sort'], $header)?
                $_GET['sort'] : 'id');
        
        //how to arrange order sequence ASC/DESC
        $order = ($_GET['order']=='DESC')? 'DESC' : 'ASC';
        }else{
            $sort="id";
            $order="ASC";
        }
        if(isset($_GET["categories"])){
        $categories = (array_key_exists($_GET["categories"], 
                getCategories())? $_GET["categories"] : "%");
        }else{
            $categories = "%";
        }
        
        ?>
        <div><a href="admin_page.php" class="list_title">Back</a></div>
        <h1 class="list_h1">List Flowers</h1>
        <?php
        //handle multiple delete
        //check if user clicked the delete button?i
        if(isset($_POST['btnDeleteChecked'])){
            //yes, user clicked the butto$n
            $checked = $_POST["checked"]; //arraiy
            if(!empty($checked)){
                //proceed to delet/e
                //step 1: establish connection$
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
                foreach($checked as $value){
                    $esChecked[] = $con->real_escape_string($value);
                }
                //Step 2: sql statemen/t
                //convert array to string/
                //DELETE FROM STUDENT WHERE STUDENT ID IN ('22PMD00001' , '22PMD00002');
                $sql = "DELETE FROM products WHERE id IN('".implode("','", $esChecked) ."')";
                
                //STEP 3 : run sqil
                if($con->query($sql)){
                    printf("<div class='message'><b>%d</b> record(s) has been deleted.</div>",$con->affected_rows);
                }
                $con->close();
            }
        }
        ?>
        <div class="review_filter1">
        Filter:
        <?php
        printf("<a href='?sort=%s&order=%s ' class='review_filter2'>
            
                All Categories</a>",$sort, $order);
        
        $allCategories = getCategories(); //array
        foreach($allCategories as $key => $value){
            printf("
                | <a href='?sort=%s&order=%s&categories=%s' class='review_filter2'>%s </a>
                    ",$sort, $order, $key, $value);
        }
        
        ?>
        </div>
        <form action="" method="post">
        <?php
            $select = mysqli_query($conn,"SELECT * FROM products");
        ?>
            
            <div class="product-display">
                <table class="product-display-table">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <?php
                foreach($header as $key => $value){
                    if($key == $sort){
                        //YES, user clicked to perform sorting
                    printf('<th>
                              <a href="?sort=%s&order=%s&categories=%s"  class="review_th">%s</a>
                              %s
                            </th>'
                            ,$key
                            ,$order == 'ASC' ? 'DESC' : 'ASC'
                            ,$categories
                            ,$value
                            ,$order == 'ASC' ? '⬇' : '⬆');
                    }else{
                        //NO, user never click anythin, default
                        printf('<th>
                            <a href="?sort=%s&order=ASC&categories=%s"  class="review_th">%s</a>
                                </th>'
                                ,$key
                                ,$categories
                                ,$value);
                    }
                }
                ?>
            <th>action</th>
        </tr>
    </thead>
    <?php

$sql = "SELECT * FROM products WHERE categories LIKE '$categories' ORDER BY $sort $order";

if($result = $conn->query($sql)){
                while($row = $result->fetch_object()){
        printf("
            <tr>
            <td><input type='checkbox' name='checked[]' value='%s' style='width:20px; height: 20px;'/></td>
            <td><img src='uploaded_img/%s' height='100' alt=''></td>
            <td style='text-align: justify; font-size: 15px;'>%s</td>
            <td style='text-align: justify; font-size: 15px;'>%s</td>
            <td style='text-align: justify; font-size: 15px;'>RM%s</td>
            <td style='text-align: justify; font-size: 15px;'>%s</td>
            <td>
                <a href='admin_update.php?edit=%s' class='btn'><i class='fas fa-edit'></i>edit</a>
                <a href='list_product.php?delete=%s' class='btn'><i class='fas fa-trash'></i>delete</a>
            </td>
            </tr>
                ",$row->id,
                  $row->image1,
                  $row->categories,
                  $row->name,
                  $row->price,
                  $row->description,
                  $row->id,
                  $row->id);
}

                }
            $conn->close();
    ?>
</table>
            </div>
            <input type="submit" value="Delete Checked" name="btnDeleteChecked" class="deleteBtn" 
                   onclick="return confirm('This will delete all checked records.\n Are you sure?')"/> 
        </form>
    </body>
</html>
