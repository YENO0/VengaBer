<?php
define('DB_HOST', "yy-ver1-rds.ctqigw62kpxk.us-east-1.rds.amazonaws.com");
define('DB_USER', "yen0809");
define('DB_PASS', "p3TEr100");
define('DB_NAME', "PETER");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$message = array();

$id = isset($_GET['id']) ? strtoupper(trim($_GET['id'])) : "";

if (isset($_POST['add_to_cart']) || isset($_POST['buy_now'])) {
    $product_size = $_POST['Size'];
    $product_quantity = $_POST['quantity'];

    if (empty($product_size) || empty($product_quantity)) {
        $message[] = 'Please fill in all the requirements';
    } else {
        $insert = "INSERT INTO orders (product_size, product_quantity, id) VALUES ('$product_size', '$product_quantity', '$id')";
        if (mysqli_query($con, $insert)) {
            $message[] = "Order added to cart successfully";
        } else {
            $message[] = "Error inserting data: " . mysqli_error($con);
        }
    }
}
$con->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewpoint" content="width=device-width,initial-scale=1.0">
        <title>Tulip</title>
        <link href="css/product.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
              integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <?php include './header1.php'; ?>
        <?php
        // Retrieve admin id and admin email from cookies
        $user_id = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : '';
        ?>
        <div class="main-wrapper">
            <div class="container">
                <?php
                foreach ($message as $value) {
                    echo "<span class='message'>$value</span>";
                }
                ?>
                <?php
                $userID = isset($_GET['user_id']) ? trim($_GET['user_id']) : "";
                echo '<a href="flowers_tulip.php?user_id=' . $userID . '" class="back1">Back</a>';
                ?>
                <div class="product-div">
                    <div class="product-div-left">
                        <?php
                        $id = $_GET['id'];
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                        $sql = "SELECT * FROM products WHERE id = $id";
                        if ($result = $con->query($sql)) {
                            while ($record = $result->fetch_object()) {
                                printf("
                            <div class='img-container'><center>
                            <img src='uploaded_img/%s' height='400' alt=''>
                            </center></div>
                            <div class='hover-container'>
                            <div class='productImage'>
                                    <img src='uploaded_img/%s' class='image2'>
                            </div>
                            <div class='productImage'>
                                    <img src='uploaded_img/%s' class='image2'>
                            </div>
                            </div>", $record->image1, $record->image1, $record->image2);
                            }
                        }
                        $result->free();
                        $con->close();
                        ?>
                    </div>
                    <div class="product-div-right">
                        <?php
                        $id = $_GET['id'];
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                        $sql = "SELECT * FROM products WHERE id = $id";
                        if ($result = $con->query($sql)) {
                            while ($record = $result->fetch_object()) {
                                printf("
                            <span class='product-name'>%s</span>
                            <span class='product-price'>RM %s.00</span><br/>", $record->name, $record->price);
                            }
                        }
                        $result->free();
                        $con->close();
                        ?>
                        <form method="POST" action="cart.php?user_id=<?php echo $user_id; ?>&id=<?php echo $id; ?>">
                            Size:
                            <select name="Size">
                                <option value="S">Small</option>
                                <option value="M">Medium</option>
                                <option value="L">Large</option>
                            </select>
                            Quantity: <input type="number" name="quantity" value="1" class="quantity" min="1"/>
                            <?php
                            $id = $_GET['id'];
                            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                            $sql = "SELECT * FROM products WHERE id = $id";
                            if ($result = $con->query($sql)) {
                                while ($record = $result->fetch_object()) {
                                    printf("<p class='product-description'>%s</p>", $record->description);
                                }
                            }
                            $result->free();
                            $con->close();
                            ?>
                            <div class="product-rating">
                                <span class='rating1'>Click here <a class='review' href='newReview2.php'><b>[Review]</b></a> to see our reviews.</span>
                            </div>
                            <div class='btn-groups'>
                                <input type="submit" class="add-cart-btn" name="add_to_cart" value="Add To Cart"/>
                                <input type="hidden" name="prodID" value="<?php echo $id; ?>" />
                                <input type="hidden" name="custID" value="<?php echo $user_id; ?>" />
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <script src="product.js" type="text/javascript"></script>
        <footer><?php include './footer1.php'; ?></footer>
    </body>
</html>
