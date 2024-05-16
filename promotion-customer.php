<?php 
  if (!isset($_COOKIE["UserID"])) {
            echo "<script>alert('PLEASE LOGIN TO SEE AND USE PROMOTION!!!')</script>";
            echo "<script>window.location.href='./login-customer.php';</script>";
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Promotion</title>
        <link href="promotion-customer.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image: url('image./background_3.jpg'); 
          background-repeat: no-repeat; background-size: cover; 
          background-position: center;">
        
        <?php include './header1.php'; 
              require_once './config/database.php';?>
        
        <center><h1>PROMOTION</h1></center>
        <div class="search-container">
    <form class="search1" method="post">
        <input type="text" placeholder="Search" name="search" style="position:relative;left:-450px;">
        <input type="submit" value="Search" class="searchBtn"><br><br>
    </form>
</div>

    <?php 
    $header=array('Promotion For' => 'Promotion For',
              'Promotion Code' => 'Promotion Code',
              'Promotion Details' =>'Promotion Details',
              );
    ?>

    <?php
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if(isset($_POST['search'])){
    $hideCart = true;
    // Save and trim the input inside a variable
    $search = trim($_POST['search']);
    $search = strtoupper($search);

    // SQL statement with search
    $sql = "SELECT * FROM promotiong WHERE PromotionF LIKE '%$search%' OR PromotionCode LIKE '%$search%' OR DescriptionP LIKE '%$search%'";
    } else {
    // SQL statement without search
    $sql = "SELECT * FROM promotiong";
    }

    $count = 0;
    if($result = $con->query($sql)){
    if ($result->num_rows > 0) {
        ?>
        <table class="searchTable">
            <tr class="searchTr">
                <?php
                foreach($header as $key => $value)
                    printf('<th class="searchTh">%s</th>',$value);
                ?>
            </tr> 
            <tbody>
                <?php
                while($record = $result->fetch_object()){
                    printf("
                        <tr class='searchTr'>
                        <td class='searchTd'>%s</td>
                        <td class='searchTd'>%s</td>
                        <td class='searchTd'>%s</td>
                        </tr>
                        ",$record->PromotionF
                         ,$record->PromotionCode
                         ,$record->DescriptionP);

                    $count++;
                }
                ?>
            </tbody>
        </table>
        <?php
        } else {
        echo "<p class='wrong'>No promotion found.<a href='promotion-customer.php'>Back.</a><p>";
        }
        $result->free();
        } else {
        echo "<div class='wrong'>Error: " . $con->error . "</div>";
        }

        $con->close();
        ?>

      <?php include './footer1.php'; ?>
        
    </body>
</html>


