<?php
require_once './config/helper.php';
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Order Confirmation Page</title>
        <link href="css/orderconfirmation.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image: url(images/3.jpg);background-size: cover;background-repeat: no-repeat;">
        <?php
        include './adminHeader1.php';
        ?>
        <br/>
        <form action='adminorder.php' method='POST'>
    <center>
        <table border="1">
            <tr>
                <th><h2>Confirmation For Cancelling Order</h2></th>
            </tr>
        <?php
        (isset($_GET['OrderID']))?
        $OrderID = trim($_GET['OrderID']):
        $OrderID = "";
        $con = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM orders WHERE OrderID = $OrderID";
        $result = $con->query($sql);
        $record = $result->fetch_object();
        $sql2 = "SELECT * FROM products WHERE id = $record->ProductID";
        $result2 = $con->query($sql2);
        $record2 = $result2->fetch_object();
        $sql3 = "SELECT * FROM loginc WHERE UserID = '$record->CustomerID'";
        $result3 = $con->query($sql3);
        $record3 = $result3->fetch_object();
        printf("<tr><td height='50px'>Order ID: %d<input type='hidden' name='orderID' value='%d' /></td></tr>
                <tr><td height='50px'>Customer Name: %s %s</td></tr>
                <tr><td height='50px'>Product Name: %s</td></tr>
                <tr><td height='50px'>Quantity: %d</td></tr>"
                , $record->OrderID, $record->OrderID, $record3->Fname, $record3->Lname,$record2->name, $record->Quantity);
        ?>
            <tr><td height="50px">Reason of cancellation: <input type="text" name="reasonTxt" value="" /></td></tr>
            
            <tr><td height="50px"><center><a href='adminorder.php'><input type="submit" value="Cancel" class="CancelRefund" name="CancelRefund" /></a>
                <input type="submit" value="Refund" class="RefundButton" name="RefundButton" /></center></td></tr>
            <input type="hidden" name="validation" value="true" />
        </table>
    </center>
        </form>
        <br/>
    </body>
    <?php
        include './footer1.php';
        ?>
</html>