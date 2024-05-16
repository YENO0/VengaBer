<?php
require_once './config/helper.php';
if(!isset($_POST['purchaseBtn'])){
    echo "<p class='error'><b>PURCHASE BUTTON</b> was not clicked! Please try again.</p>";
}else{
        (isset($_GET['user_id']))?
        $user_id = trim($_GET['user_id']):
        $user_id = "";
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "INSERT INTO payment (CustomerID, Subtotal, Total) VALUES (?,?,?)";
        $sql2 = "SELECT * FROM cart WHERE CustomerID = '$user_id'";
                if($result = $con->query($sql2)){
                if(mysqli_num_rows($result) > 0){
                while($record = $result->fetch_object()){
                    (isset($subtotal))?
                    $subtotal = trim($subtotal):
                    $subtotal = 0.00;
                    $subtotal = $subtotal + ($record->Price*$record->Quantity);
                    $shippingFee = 20.00;
                }
                $total = $subtotal + $shippingFee;
                }
        $stmt = $con->prepare($sql);
        $stmt->bind_param('sss', $user_id, $subtotal, $total);
        $stmt->execute();
        if($stmt->affected_rows > 0){
        $user_id = $subtotal = $total = NULL;
            }
        $stmt->close();
        $con->close();
        $result->free();
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
        <title>Payment</title>
        <link href="css/payment.css" rel="stylesheet" type="text/css"/>
        <style>
            .payment-left{
    width:50%;
    float: left;
    padding:20px;
            }
.payment-right{
    width:50%;
    padding:20px;
}
.payment-input{
    height: 40px !important;
    width: 100% !important;
    border:1px solid #333 !important;
    border-radius: 5px !important;
}
        </style>
    </head>
    <body style="background-image:url(image/background_1.jpg);
                 background-repeat:no-repeat;
                 background-size:cover;">
        <?php
        include "./header1.php";
        ?>
        <div style='width:1240px;margin:150px auto; display:flex;'>
            <?php
        if(isset($_POST['purchaseBtn'])){
    echo "";
            (isset($_GET['user_id']))?
            $user_id = trim($_GET['user_id']):
            $user_id = "";
            printf("<div class='payment-left'>
                    <form method='POST' action='paymentResult.php?user_id=%s'>", $user_id);

    echo "<div style='display:grid;grid-template-columns: repeat(2,1fr);gap:10px;'>
        <div>Payment Method: </div>

        <div><select class='payment-input' name='paymentMethod' required>
            <option disabled selected value> -- select an option -- </option>
            <option value='MasterCard'>MasterCard</option>
            <option value='Visa'>Visa</option>
            </select></div>";
    echo "
            
            <div>Card Number:</div>
            <div><input type='text' name='cardNum' value='' class='payment-input' size='19' maxlength='19' placeholder='0000 0000 0000 0000' required/></div>
            <div>Expiry Date:</div>
            <div><input type='text' class='payment-input' name='expDate' value='' size='5' maxlength='5' placeholder='00/00' required/></div>
            <div>CVV Code:</div>
            <div><input type='password' class='payment-input' name='cvv' value='' size='3' maxlength='3' required/></div>
          
                <input type='submit' value='Confirm Purchase' class='' name='purchaseButton'/>";
    (isset($_GET['user_id']))?
                $user_id = trim($_GET['user_id']):
                $user_id = "";
                echo "<input type='button' value='Cancel' class='' name='cancelBtn' onclick=\"location='cart.php?user_id=$user_id'\"/>
              </div>
            </form>
            </div>
           <div class='payment-right'>
           <div style='display:grid;grid-template-columns: repeat(2,1fr);gap:10px;'>
          ";
                         (isset($_GET['user_id']))?
            $user_id = trim($_GET['user_id']):
            $user_id = "";
            $con = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT * FROM cart WHERE CustomerID = '$user_id'";
            $total = 0;
            if($result = $con->query($sql)){
            if(mysqli_num_rows($result) > 0){
            while($record = $result->fetch_object()){
            printf("<div>Product Name:</div> <div>%s</div><div>Total Price:</div><div> RM%.2lf</div>"
                                    ,$record->ProductName,$record->Price*$record->Quantity);
            $total = $total + ($record->Price*$record->Quantity) + $shippingFee;
            }
            }
            }
            $con->close();
            $result->free();
                echo"</div>";
                echo"<hr>";
                echo"<div  style='display:grid;grid-template-columns: repeat(2,1fr);gap:10px;'>";
                echo "<div>Total with shipping fee:</div><div>RM$total</div>
            </div>
            </div>
       
   
    </div>
    </center>";
        }
        
    ?>
    </div>
    <?php
        include "./footer1.php";
        ?>
   </body>
</html>