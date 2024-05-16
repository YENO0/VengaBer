<?php
if (!isset($_COOKIE["UserID"])) {
    echo "<script>alert('PLEASE LOGIN TO SEE YOUR CART!!!')</script>";
    echo "<script>window.location.href='./login-customer.php';</script>";
}
?>

<?php
require_once './config/helper.php';
(isset($_GET['user_id'])) ?
                $userID = trim($_GET['user_id']) :
                $userID = "";
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql2 = "SELECT * FROM payment WHERE CustomerID = '$userID'";
$result2 = $con->query($sql2);
if ($result2->num_rows > 0) {
    $sql = "DELETE FROM payment WHERE CustomerID = '$userID'";
    $result = $con->query($sql);
}
$result2->free();
$con->close();
if (isset($_POST['buy_now'])) {
    (isset($_GET['id'])) ? $pID = trim($_GET['id']) : $pID = '';
    (isset($_POST['Size'])) ? $size = trim($_POST['Size']) : $size = '';
    (isset($_POST['quantity'])) ? $qty = trim($_POST['quantity']) : $qty = '';
    (isset($_GET['user_id'])) ?
                    $user_id = trim($_GET['user_id']) :
                    $user_id = "";

    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM products WHERE id = $pID";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $record = $result->fetch_object();
        $img = $record->image1;
        $name = $record->name;
        $price = $record->price;
    }
    $CartID = rand(1, 90000);
    $sql2 = "INSERT INTO cart (CartID,CustomerID, ID, ProductImage, ProductName, ProductSize, Quantity, Price) VALUES ($CartID, '$user_id', '$pID', '$img', '$name', '$size', '$qty', '$price')";

    $con->query($sql2);
    $result->free();
    $con->close();
} else if (isset($_POST['add_to_cart'])) {
    (isset($_POST['Size'])) ?
                    $size = trim($_POST['Size']) :
                    $size = '';
    (isset($_POST['quantity'])) ?
                    $qty = trim($_POST['quantity']) :
                    $qty = '';
    $pID = trim($_POST['prodID']);
    $user_id = trim($_POST['custID']);
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM products WHERE id = $pID";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $record = $result->fetch_object();
        $img = $record->image1;
        $name = $record->name;
        $price = $record->price;
    }
    $CartID = rand(1, 90000);
    $sql2 = "INSERT INTO cart (CartID, CustomerID, ID, ProductImage, ProductName, Quantity, Price) VALUES ($CartID,'$user_id', '$pID', '$img', '$name', '$qty', '$price')";

    $con->query($sql2);
    $con->close();
    $result->free();
}
?>

<?php
//update
if (isset($_POST['editBtn'])) {
   
        (isset($_GET['user_id'])) ?
                        $cID = (trim($_GET['user_id'])) :
                        $cID = "";
        (isset($_GET['id'])) ?
                        $ID = (trim($_GET['id'])) :
                        $ID = "";
        (isset($_POST['pName'])) ?
                        $ProductName = trim($_POST['pName']) :
                        $ProductName = "";
        (isset($_POST['price'])) ?
                        $Price = trim($_POST['price']) :
                        $Price = "";
        (isset($_POST['quantity'])) ?
                        $quantity = trim($_POST['quantity']) :
                        $quantity = "";
        
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "UPDATE cart SET Quantity = ? WHERE ID = ? AND CustomerID = ?";
    $stmt = $con->prepare($sql);
        $stmt->bind_param('iis', $quantity, $ID, $cID);
    if ($stmt->execute()) {
            (isset($_GET['user_id'])) ?
                            $cID = (trim($_GET['user_id'])) :
                            $cID = "";
            $message['successful'] = 'Edit was successful';
        } else {
            $message['failed'] = 'Edit was unsuccessful';
        }
        $con->close();
        $stmt->close();
   
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cart</title>
        <script src="https://kit.fontawesome.com/692d068c27.js" crossorigin="anonymous"></script>
        <link href="css/cart.css" rel="stylesheet" type="text/css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
        <script>
            function validateTotal() {
                var total = parseFloat(document.getElementById('totalAmount').innerText.replace('RM', ''));
                if (total === 0) {
                    alert("Total amount cannot be 0. Please add items to your cart.");
                    return false;
                }
                return true;
            }
        </script>
    </head>
    <body style="overflow-y: visible;">
        <?php require './header1.php'; ?>
        <div class="cart_row no-padding-updown">
            <h1 class="caption">Cart</h1>
            <?php
            if (!empty($message)) {
                echo "<div class='info'>";
                printf("<ul class='errorList'><li style='font-size:20px;'>%s</li></ul>", implode("</li><li>", $message));
                echo "</div>";
            }
            ?>
        </div>
        <?php
        global $hideCart, $user_id;
        if ($_SERVER["REQUEST_METHOD"] == 'GET') {
            (isset($_GET['user_id'])) ? $user_id = trim($_GET['user_id']) : $user_id = "";
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT * FROM cart WHERE CustomerID = '$user_id'";
            $result = $con->query($sql);
            if ($record = $result->fetch_object()) {
                $user_id = $record->CustomerID;
                $ID = $record->ID;
                $ProductName = $record->ProductName;
                $size = $record->ProductSize;
                $Price = $record->Price;
                $quantity = $record->Quantity;
            } else {
                (isset($_GET['user_id'])) ? $user_id = trim($_GET['user_id']) : $user_id = "";
                echo "<div class='' style='height:300px;text-align:center;'>There's nothing inside your cart [ <a href='homepage.php?user_id=$user_id'>Back to home page</a> ]</div>";
                $hideCart = true;
            }
            $con->close();
            $result->free();
        }
        ?>

        <?php
        if (isset($_POST['deleteBtn2'])) {
            (isset($_POST['checked'])) ? $checked = $_POST["checked"] : $checked = array();
            if (!empty($checked)) {
                (isset($_GET['user_id'])) ? $user_id = trim($_GET['user_id']) : $user_id = "";
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                foreach ($checked as $value) {
                    $cpDelete[] = $con->real_escape_string($value);
                }
                $sql = "DELETE FROM cart WHERE CustomerID = '$user_id' AND CartID IN ('" . implode("','", $cpDelete) . "')";
                if ($con->query($sql)) {
                    printf("<div class='deleteS'><b>%d</b> record(s) has been deleted.</div>", $con->affected_rows);
                }
                $con->close();
            }
        }
        ?>

        <?php if ($hideCart == false): ?>
            <div class="cart_row no-padding-updown" style="height: 520px; border-top: 1px solid #999;">
                <div class="cart_col-1" style="max-height: 450px;overflow-y: auto;">
                    <form action="" method="POST">
                        <?php
                        (isset($_GET['user_id'])) ? $user_id = trim($_GET['user_id']) : $user_id = "";
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        $sql = "SELECT * FROM cart WHERE CustomerID = '$user_id'";
                        if ($result = $con->query($sql)) {
                            if (mysqli_num_rows($result) > 0) {
                                while ($record = $result->fetch_object()) {
                                    $sql2 = "SELECT * FROM products WHERE id = $record->ID";
                                    if ($results = $con->query($sql2)) {
                                        $records = $results->fetch_object();
                                        $category = $records->categories;
                                        if ($category != "hat" && $category != "bag") {
                                            printf("
                                            <div class='cart_product'>
                                                <div class='cart_product_1'>
                                                    <input type='checkbox' name='checked[]' value='%s' />
                                                </div>
                                                <div class='cart_product_2'>
                                                    <img src='uploaded_img/%s' class='cart_img'>
                                                </div>
                                            </div>
                                            <div class='cart_product1'>
                                                <div>Product Name:</div>
                                                <div class='cart_value'>%s</div>
                                                <div>Price:</div>
                                                <div class='cart_value'>RM%s.00</div>
                                                <div>Quantity:</div>
                                                <div class='cart_value'>x%d</div>
                                                <div><a href='editcart.php?id=%d&user_id=%s'><input type='button' value='Edit' name='editBtn'/></a></div>
                                            </div>
                                        ", $record->CartID, $record->ProductImage, $record->ProductName, $record->Price, $record->Quantity, $record->ID, $record->CustomerID);
                                        } else {
                                            printf("
                                            <input type='checkbox' name='checked[]' value='%s' />
                                            <div class='cart_product' style='padding:25px;'>
                                                <img src='uploaded_img/%s' class='cart_img'>
                                            </div>
                                            <div class='cart_product'>
                                                Product Name: %s
                                                Price: %s
                                                Quantity: %d
                                            </div>
                                            <div class='cart_product'>
                                                <a href='editcart.php?id=%d&user_id=%s'><input type='button' value='Edit' name='editBtn'/></a>
                                            </div>
                                        ", $record->CartID, $record->ProductImage, $record->ProductName, $record->Price, $record->Quantity, $record->ID, $record->CustomerID);
                                        }
                                    }
                                }
                            }
                        }
                        $con->close();
                        $result->free();
                        ?>
                        <input type="submit" class="deleteBtn2" style='margin: 20px 0;' value="Delete Selected Items" name="deleteBtn2" />
                    </form>
                </div>
                <div class="cart_col-1" style="padding:20px;background-color:white;border-left: 1px solid #999;height: 450px; font-size: 14px;">
                    <?php
                    (isset($_GET['user_id'])) ? $user_id = trim($_GET['user_id']) : $user_id = "";
                    printf("<form action='payment.php?user_id=%s' method='POST' onsubmit='return validateTotal()'>", $user_id);
                    ?>
                    <h2 style="text-align: center;margin: 0;">Summary</h2>

                    <div style="height: 200px;max-height: 200px;overflow-y: auto;">
                        <ul style="padding-inline-start:20px;">
                            <?php
                            (isset($subtotal)) ? $subtotal = trim($subtotal) : $subtotal = 0;
                            (isset($_GET['user_id'])) ? $user_id = trim($_GET['user_id']) : $user_id = "";
                            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                            $sql = "SELECT * FROM cart WHERE CustomerID = '$user_id'";
                            if ($result = $con->query($sql)) {
                                if (mysqli_num_rows($result) > 0) {
                                    while ($record = $result->fetch_object()) {
                                        printf("<li>%s x%d</li>", $record->ProductName, $record->Quantity);
                                        $subtotal = $subtotal + ($record->Price * $record->Quantity);
                                        $shippingFee = 20.00;
                                    }
                                } else {
                                    $shippingFee = 0.00;
                                }
                                $con->close();
                                $result->free();
                            }
                            ?>
                        </ul>
                    </div>
                    <br>
                    <div class="cart-summary-grid">
                        <div>SubTotal:</div>
                        <div class="cart-summary-grid-right">
                            <?php
                            printf("RM%.2lf", $subtotal);
                            $total = $subtotal + $shippingFee;
                            ?>
                        </div>
                        <div>Shipping Fee:</div>
                        <div class="cart-summary-grid-right">
                            <?php printf("RM%.2lf", $shippingFee); ?>
                        </div>
                    </div>
                    <hr>
                    <div class="cart-summary-grid" style="margin-bottom: 70px;">
                        <div><b>Total:</b></div>
                        <div class="cart-summary-grid-right">
                            <b id="totalAmount"><?php printf("RM%.2lf", $total); ?></b>
                        </div>
                    </div>
                    <div style="text-align: center;">
                        <input type='submit' value='Confirm Purchase' name='purchaseBtn' class='purchaseBtn'/>
                    </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php include './footer1.php'; ?>
    </body>
</html>
