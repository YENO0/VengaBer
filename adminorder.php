<?php
require_once './config/helper.php';
define("shippingFee", 20);
if(isset($_POST['validation'])){
if(isset($_POST['RefundButton'])){
    if(!empty($_POST['reasonTxt'])){
    $OrderID = trim($_POST['orderID']);
    $reason = trim($_POST['reasonTxt']);
    $con = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql2 = "SELECT * FROM orders WHERE OrderID = $OrderID";
    $result = $con->query($sql2);
    if($record = $result->fetch_object()){
        $sql3 = "SELECT * FROM products WHERE id = $record->ProductID";
        $result3 = $con->query($sql3);
        $record3 = $result3->fetch_object();
        $total = $record3->price*$record->Quantity+shippingFee;
        $cardNum = $record->CardNumber;
        $refundMsg = "<b>RM$total</b> has been refunded to <b>$cardNum</b> due to $reason";
    }
    $result->free();
    $sql = "DELETE FROM orders WHERE OrderID = $OrderID";
    $con->query($sql);
    $con->close();
}else{
    $error['reason']='No reason was given for this cancellation so the refund was cancelled!';
}
}else{
    $error['btn']='Refund button was not clicked! Please try again.';
}
}
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Order Page</title>
        <script src="https://kit.fontawesome.com/692d068c27.js" crossorigin="anonymous"></script>
        <link href="css/order.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image:url('images/3.jpg');background-size:cover;background-repeat:no-repeat;">
        <?php include './adminHeader1.php'; ?>

        <?php
        if(isset($_POST['search'])){
            $search = trim($_POST['search']);
            $hideOrder = true;
            echo "<center>
              <table class='order'>
              <tr>
                    <th>Order ID</th>
                    <th>Customer Details</th>
                    <th>Product Image</th>
                    <th>Product Details</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>&nbsp;</th>
                </tr>";
            $con = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT * FROM orders WHERE ProductID = $search";
                $result = $con->query($sql);
                if($result->num_rows > 0){
                while($record = $result->fetch_object()){
                    $sql2 = "SELECT * FROM products WHERE id = $record->ProductID";
                    $sql3 = "SELECT * FROM loginc WHERE UserID = '$record->CustomerID'";
                    $result2 = $con->query($sql2);
                    $result3 = $con->query($sql3);
                    $record2 = $result2->fetch_object();
                    $record3 = $result3->fetch_object();
                    printf("<tr>
                        <td class='cust'>Order ID:$record->OrderID</td>
                        <td class='cust'>Customer ID:%s <br/> Full Name: %s %s</td>
                        <td class='image'><img width=100px; src='uploaded_img/%s'></td>
                        <td class='product'>Product ID: %d <br/>
                        Product Name: %s <br/>
                        Price per product: %s</td>
                        <td class='qty'>Quantity Bought: %d</td>
                        <td class='price'>RM%.2lf</td>
                        <td class='refundz'><a href='adorderconfirmation.php?OrderID=$record->OrderID'><input type='submit' class='refundBtn' value='Cancel / Refund' name='refundBtn'/></a></td>
                           </tr>",$record->CustomerID, $record3->Fname, $record3->Lname, $record2->image1, $record2->id, $record2->name, $record2->price, $record->Quantity, $record2->price*$record->Quantity+shippingFee);
                }
                echo "<tr><td colspan=6><center><div class='back'><br/><a href='adminorder.php'>Go Back?</a></div></center></td></tr>";
                echo "</table>";
                echo "</center>";
                }else{
                    printf("No one has ordered anything! [ <a href='homepage.php?user_id=$userID'> Back to home page! </a> ]");
                }
        }else{
            $search = "";
            $hideOrder = false;
        }
        ?>
        <?php if ($hideOrder == false): ?>
            <center>
            <?php
            if(!empty($error)){
                echo "<div class='error'>";
                echo "<h2><center>Cancellation failed</center></h2>";
                printf("<ul class='errorList'><li>%s</li></ul>", implode("</li><li>",$error));
                echo "</div>";
            }
            if(!empty($refundMsg)){
                printf("<div class='refunded'><h3>$refundMsg</h3></div>");
            }
            ?>
            <table class="order">
                <?php
                $con = new mysqli (DB_HOST,DB_USER, DB_PASS, DB_NAME);
                $sql = "SELECT * FROM orders";
                $result = $con->query($sql);
                if($result->num_rows > 0){
                    echo "<tr>
                    <th>Order Details</th>
                    <th>Customer Details</th>
                    <th>Product Image</th>
                    <th>Product Details</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>&nbsp;</th>
                </tr>";
                while($record = $result->fetch_object()){
                    $sql2 = "SELECT * FROM products WHERE id = $record->ProductID";
                    $sql3 = "SELECT * FROM loginc WHERE UserID = '$record->CustomerID'";
                    $result2 = $con->query($sql2);
                    $result3 = $con->query($sql3);
                    $record2 = $result2->fetch_object();
                    $record3 = $result3->fetch_object();
                    printf("<tr>
                        <td class='cust'>Order ID:$record->OrderID</td>
                        <td class='cust'>Customer ID:%s <br/> Full Name: %s %s</td>
                        <td class='image'><img width=100px; src='uploaded_img/%s'></td>
                        <td class='product'>Product ID: %d <br/>
                        Product Name: %s <br/>
                        Price per product: %s</td>
                        <td class='qty'>Quantity Bought: %d</td>
                        <td class='price'>RM%.2lf</td>
                        <td class='refundz'><a href='adorderconfirmation.php?OrderID=$record->OrderID'><input type='submit' class='refundBtn' value='Cancel / Refund' name='refundBtn'/></a></td>
                           </tr>",$record->CustomerID, $record3->Fname, $record3->Lname, $record2->image1, $record2->id, $record2->name, $record2->price, $record->Quantity, $record2->price*$record->Quantity+shippingFee);
                }
                }else{
                    printf("No one has ordered anything! [ <a href='admin-homepage.php'> Back to home page! </a> ]");
                }
                ?>
            </table>
            </center>
    <div class="foot">
            
        </div>
        <?php endif; ?>
    </body>
    <?php
        include './footer1.php';
        ?>
</html>
