<?php 
  if (!isset($_COOKIE["UserID"])) {
            echo "<script>alert('PLEASE LOGIN TO SEE YOUR ORDER!!!')</script>";
            echo "<script>window.location.href='./login-customer.php';</script>";
}
?>

<?php
require_once './config/helper.php';
define("shippingFee", 20);
if(isset($_POST['refundBtn'])){
    $OrderID = trim($_POST['refundID']);
    (isset($_GET['user_id']))?
    $userID = trim($_GET['user_id']):
    $userID = "";
    $con = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql2 = "SELECT * FROM orders WHERE CustomerID = '$userID' AND OrderID = $OrderID";
    $result = $con->query($sql2);
    if($record = $result->fetch_object()){
        $sql3 = "SELECT * FROM products WHERE id = $record->ProductID";
        $result3 = $con->query($sql3);
        $record3 = $result3->fetch_object();
        $total = $record3->price*$record->Quantity+shippingFee;
        $cardNum = $record->CardNumber;
        $refundMsg = "<b>RM$total</b> has been refunded to <b>$cardNum</b>";
    }
    $result->free();
    $sql = "DELETE FROM orders WHERE OrderID = $OrderID";
    $con->query($sql);
    $con->close();
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
        <title>Customer Order Page</title>
        <link href="css/order.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image: url('image./background_3.jpg'); 
          background-repeat: no-repeat; background-size: cover; 
          background-position: center;">
        <div class='body'>
        <?php include './header1.php'; ?>
        <?php
        (isset($_POST['search']))?
        $search = trim($_POST['search']):
        $search ="";
        echo "<form action='' method='POST'>";
        echo "<center><h2 style='margin-top:20px;';>Welcome To Your Order Page!</h2></center>";
        echo "</form>";
        ?>
        <?php
        if(isset($_POST['search'])){
            $search = trim($_POST['search']);
            $hideOrder = true;
            echo "<center>
              <table class='order'>";
            (isset($_GET['user_id']))?
            $userID = trim($_GET['user_id']):
            $userID = "";
            $con = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT * FROM orders WHERE ProductID = $search AND CustomerID = '$userID'";
                $result = $con->query($sql);
                if($result->num_rows > 0){
                    echo "<tr>
                    <th>Product Image</th>
                    <th>Product Details</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                    </tr>";
                while($record = $result->fetch_object()){
                    $sql2 = "SELECT * FROM products WHERE id = $record->ProductID";
                    $result2 = $con->query($sql2);
                    $record2 = $result2->fetch_object();
                    printf("<tr>
                        <td class='image'><img width=100px; src='uploaded_img/%s'></td>
                        <td class='product'>Product ID: %d <br/>
                        Product Name: %s <br/>
                        Price per product: %s</td>
                        <td class='qty'>Quantity Bought: %d</td>
                        <td class='price'>RM%.2lf</td>
                        <td class='refundz'><input type='submit' class='refundBtn' value='Cancel / Refund' name='refundBtn'/><input type='hidden' name='refundID' value='%d' /></td>
                           </tr>",$record2->image1, $record2->id, $record2->name, $record2->price, $record->Quantity, $record2->price*$record->Quantity+shippingFee, $record->OrderID);
                }
                (isset($_GET['user_id']))?
                $userID = trim($_GET['user_id']):
                $userID = "";
                echo "<tr><td colspan=6><center><div class='back'><br/><a href='custorder.php?user_id=$userID'>Go Back?</a></div></center></td></tr>";
                echo "</table>";
                echo "</center>";
                }else{
                    printf("<div class='emptyorder'>You did not order this item please try again! [ <a href='custorder.php?user_id=$userID'> Back to order page! </a> ]</div>");
                    $hideOrder = true;
                }
        }else{
            $search = "";
            $hideOrder = false;
        }
        ?>
        <?php if ($hideOrder == false): ?>
        <form action="" method="POST">
            <center>
                <?php
                if(!empty($refundMsg)){
                    echo "<div class='refunded'>";
                    printf("<h3>$refundMsg</h3>");
                    echo "</div>";
                }
                ?>
            <table class="order">
                <?php
                (isset($_GET['user_id']))?
                $userID = trim($_GET['user_id']):
                $userID = "";
                $con = new mysqli (DB_HOST,DB_USER, DB_PASS, DB_NAME);
                $sql = "SELECT * FROM orders WHERE CustomerID = '$userID'";
                $result = $con->query($sql);
                if($result->num_rows > 0){
                    echo "<tr>
                    <th class='thorder'>Product Image</th>
                    <th class='thorder'>Product Details</th>
                    <th class='thorder'>Quantity</th>
                    <th class='thorder'>Total Amount</th>
                    <th class='thorder'>Action</th>
                    </tr>";
                while($record = $result->fetch_object()){
                    $sql2 = "SELECT * FROM products WHERE id = $record->ProductID";
                    $result2 = $con->query($sql2);
                    $record2 = $result2->fetch_object();
                    printf("<tr>
                        <td class='tdorder'><img width=100px; src='uploaded_img/%s'></td>
                        <td class='tdorder' style='text-align:left;'>Product Name: %s <br/>
                        Price per product: %s</td>
                        <td class='tdorder'>Quantity Bought: %d</td>
                        <td class='tdorder'>RM%.2lf</td>
                        <td class='tdorder'><input type='submit' class='refundBtn' value='Cancel / Refund' name='refundBtn'/><input type='hidden' name='refundID' value='%d' /></td>
                           </tr>", $record2->image1, $record2->name, $record2->price, $record->Quantity, $record2->price*$record->Quantity+shippingFee, $record->OrderID);
                }
                }else{
                    printf("<div class='emptyorder'>There is nothing inside your order page! [ <a href='homepage.php?user_id=$userID'> Back to home page! </a> ]</div>");
                    $hideOrder = true;
                }
                ?>
                <?php endif; ?>
            </table>
            </center>
        </form>
        </div>
        <div class="foot">
            
        </div>
    </body>
    <?php
        include './footer1.php';
        ?>
</html>
