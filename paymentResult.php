<?php
require_once './config/helper.php';
if(isset($_POST['purchaseButton'])){
        $paymentMethod = trim($_POST['paymentMethod']);
        $cardNum= trim($_POST['cardNum']);
        $expiryDate = trim($_POST['expDate']);
        $cvv = trim($_POST['cvv']);
        $year = substr(date("Y"),-2);
        $month = date("m");
        (isset($_POST['promoCode']))?
        $promoCode = trim($_POST['promoCode']):
        $promoCode = "";
        $con = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM promotiong WHERE PromotionCode = '$promoCode'";
        if($result = $con->query($sql)){
        if(mysqli_num_rows($result) > 0){
        $record = $result->fetch_object();
        $promoAmt = $record->PromotionP;
        }else{
            if($promoCode == "")
            $promotion = "";
            else
            $promotion = "This promotion code does not exist.<br/>";
            $promoAmt = 0;
        }
    }    
    $con->close();
    $result->free();
if(strlen($cardNum)!=19){
    $error['cardNumber']="Your <b>CARD NUMBER</b> must contain 19 digits including spaces!";
}
if($paymentMethod == "MasterCard"){        
if(!preg_match('/^5[0-9]{3} [0-9]{4} [0-9]{4} [0-9]{4}$/', $cardNum)){
    $error['cardNum']= "Your <b>CARD NUMBER</b> does not match with your payment method.";
}
}else if($paymentMethod == "Visa"){
if(!preg_match('/^4[0-9]{3} [0-9]{4} [0-9]{4} [0-9]{4}$/', $cardNum)){
    $error['cardNum'] = "Your <b>CARD NUMBER</b> does not match with your payment method.";
}
}
if(!preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $expiryDate)){
    $error['date'] = "The <b>EXPIRY DATE</b> you've entered is not a date! Please try again.";
}else if(substr($expiryDate,-2) < $year || substr($expiryDate,0,2)<=$month && substr($expiryDate,-2) == $year){
    $error['date'] = "Your card is <b>EXPIRED</b>.";
}

if(strlen($cvv)!=3){
    $error['cvv'] = "Your <b>CARD VERIFICATION VALUE</b> must contain 3 digits.";
}
if(empty($error)){
    (isset($_GET['user_id']))?
        $user_id = trim($_GET['user_id']):
        $user_id = "";
$con = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "UPDATE payment SET PaymentMethod = ?,CardNumber = ?,ExpDate = ?,cvv = ? WHERE CustomerID = '$user_id'";
        $stmt = $con->prepare($sql);
                $stmt->bind_param('ssss', $paymentMethod, $cardNum, $expiryDate, $cvv);
                $stmt->execute();
                if($stmt->affected_rows > 0){
                    $paymentMethod = $cardNum = $expiryDate = $cvv = NULL;
                }
                $con->close();
                $stmt->close();
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
        <title>Payment Result</title>
        <link href="css/paymentResult.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image:url(image/background_1.jpg);
                 background-repeat:no-repeat;
                 background-size:cover;">
        <?php include './header1.php';?>
    <center>
        <table class="paymentRslt" border="2px solid black" height="220px"width='500px'>
    <tr>
    <td style='border:none;'>
<?php
if(isset($_POST['purchaseButton'])){
global $error;
if(!empty($error)){
echo "<h2><center>Transaction failed</center></h2>";
printf("<ul class='errorList'><li>%s</li></ul>", implode("</li><li>",$error));
}else{
    echo "<h2><center>Transaction Accepted!</center></h2>
    Products purchased:<br/>";
    (isset($_GET['user_id']))?
        $user_id = trim($_GET['user_id']):
        $user_id = "";
    $con = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM cart WHERE CustomerID = '$user_id'";
    if($results = $con->query($sql)){
                if(mysqli_num_rows($results) > 0){
                while($record = $results->fetch_object()){
    printf("<li class='productList'>%d %s</li><br/>", $record->Quantity, $record->ProductName);
                }
        }
    }
    $con->close();
    $results->free();
    //add records into order
    (isset($_GET['user_id']))?
    $userID = trim($_GET['user_id']):
    $userID = "";
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT c.ID as ProductID, c.Quantity, p.Total, p.CardNumber
        FROM cart c
        JOIN payment p ON c.CustomerID = p.CustomerID
        WHERE c.CustomerID = '$userID'";
if($results = $con->query($sql)){
    if(mysqli_num_rows($results) > 0){
        while($record = $results->fetch_object()){
                $id = $record->ProductID;
                $cardNum = $record->CardNumber;
                $qty = $record->Quantity;
                $OrderID = rand(1,90000);
                $sql3 = "INSERT INTO orders (OrderID, CustomerID, ProductID, CardNumber, Quantity) VALUES (?,?,?,?,?)";
                $stmt = $con->prepare($sql3);
                $stmt->bind_param('isisi', $OrderID, $userID, $id, $cardNum, $qty);
                $stmt->execute();
        }
                $stmt->close();
    }
    $results->free();
    $con->close();
}
    //delete record from cart
    (isset($_GET['user_id']))?
        $user_id = trim($_GET['user_id']):
        $user_id = "";
    $total = 0;
    $con = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM payment WHERE CustomerID = '$user_id'";
    $result = $con->query($sql);
    while($record = $result->fetch_object()){
    $user_id = $record->CustomerID;
    $total = $total + $record->Total;
    $paymentMethod = $record->PaymentMethod;
    $cardNum = $record->CardNumber;
    }
    $result->free();
    if(!empty($promotion))
        printf("$promotion");
    else if(empty($promotion))
        printf("Promotion: RM%.2lf<br/>", $total*$promoAmt);
    echo "Total Amount Paid: RM" . $total-($total*$promoAmt) . "<br/>";
    echo "Payment Method: " . $paymentMethod . "<br/>";
    echo "Card Number: **** **** **** " . substr($cardNum,-4) . "<br/>";
    $sql3 = "DELETE FROM cart WHERE CustomerID = '$user_id'";
    $sql4 = "DELETE FROM payment WHERE CustomerID = '$user_id'";
    $con->query($sql3);
    $con->query($sql4);
    $con->close();
}
}else{
    echo "<h2>Purchase Button was not clicked. Please try again</h2>";
}
        ?>
    </tr>
    <tr>
        <td style="border:none;">
    <center>
        <?php 
        (isset($_GET['user_id']))?
        $user_id = trim($_GET['user_id']):
        $user_id = "";
        printf("<br/><a href='newReview2.php?user_id=%s'><button class='homeBtn'>Go to Review?</button></a>", $user_id); 
        ?>
    </center>
                </td>
        </tr>
        </table>
    </center>
    <?php include './footer1.php';?>
    </body>
</html>
