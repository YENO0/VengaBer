<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/editCart.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include './header1.php';
        
        require_once './config/helper.php';
        ?>
    <center><h2>Edit Cart Products</h2></center>
        <?php
        global $hideForm, $ProductName, $Price;
        if($_SERVER["REQUEST_METHOD"] == 'GET'){
            //retrieve record and display
            //retrieve id from url
            (isset($_GET['id']))?
            $pID = (trim($_GET['id'])):
                $pID = "";
            $con = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM cart WHERE ID = '$pID'";
        $result = $con->query($sql);
            if($record = $result->fetch_object()){
                //record found
                $pID = $record->ID;
                $ProductName = $record->ProductName;
        $Price = $record->Price;
                $quantity = $record->Quantity;
            }else{
                (isset($_GET['user_id']))?
            $cID = (trim($_GET['user_id'])):
                $cID = "";
                //record not found
                echo "<center>Unable to retrieve record! [ <a href='cart.php?user_id=$cID'>Back to cart</a> ]</center><br/><br/>";
                
                $hideForm = true;
            }
            $con->close();
            $result->free();
        }
        ?>
    
        <?php if($hideForm == false):
        printf ("<form action='cart.php?user_id=%s&id=%d' method='POST'>", $user_id, $pID);
        ?>
            <center>
    <table border = 1>
        <tr><td height="50px"><center>Product ID: <?php echo $pID; ?><input type="hidden" name="cpID" value="<?php echo $pID; ?>"></center></td></tr>
    <tr><td height="50px"><center>Product Name: <?php echo $ProductName ?><input type="hidden" name="pName" value="<?php echo $ProductName; ?>"></center></td></tr>
    <tr><td height="50px"><center>Price: RM<?php echo $Price ?><input type="hidden" name="price" value="<?php echo $Price; ?>"></center></td></tr>
    <tr><td height="50px"><center>Quantity: <input type='number' name='quantity' min='1' max='20' value='<?php echo $quantity; ?>' /></center></td></tr>
        <?php
        (isset($_GET['id']))?
        $ID = (trim($_GET['id'])):
        $ID = "";
        $con = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM products WHERE id = $ID";
        if($results = $con->query($sql)){
        $record = $results->fetch_object();
        $category = $record->categories;
    }
    $con->close();
    $results->free();
        if($category == "shoes"){
        echo "<tr><td height='50px'><center><input type='radio' name='Size' value='UK 05.5' class='size-btn' id='opt1'/><label for='opt1'>UK 05.5</label> 
                                <input type='radio' name='Size' value='UK 06.0' class='size-btn' id='opt2'/><label for='opt2'>UK 06.0</label> 
                                <input type='radio' name='Size' value='UK 06.5' class='size-btn' id='opt3'/><label for='opt3'>UK 06.5</label> 
                                <input type='radio' name='Size' value='UK 07.0' class='size-btn' id='opt4'/><label for='opt4'>UK 07.0</label>
                                <input type='radio' name='Size' value='UK 07.5' class='size-btn' id='opt5'/><label for='opt5'>UK 07.5</label>
                                <input type='radio' name='Size' value='UK 08.0' class='size-btn' id='opt6'/><label for='opt6'>UK 08.0</label><br/><br/>
                                <input type='radio' name='Size' value='UK 08.5' class='size-btn' id='opt7'/><label for='opt7'>UK 08.5</label>
                                <input type='radio' name='Size' value='UK 09.0' class='size-btn' id='opt8'/><label for='opt8'>UK 09.0</label>
                                <input type='radio' name='Size' value='UK 09.5' class='size-btn' id='opt9'/><label for='opt9'>UK 09.5</label>
                                <input type='radio' name='Size' value='UK 10.0' class='size-btn' id='opt10'/><label for='opt10'>UK 10.0</label>
                                <input type='radio' name='Size' value='UK 10.5' class='size-btn' id='opt11'/><label for='opt11'>UK 10.5</label>
                                <input type='radio' name='Size' value='UK 11.0' class='size-btn' id='opt12'/><label for='opt12'>UK 11.0</label><br/><br/>
                                <input type='radio' name='Size' value='UK 11.5' class='size-btn' id='opt13'/><label for='opt13'>UK 11.5</label>
                                <input type='radio' name='Size' value='UK 12.0' class='size-btn' id='opt14'/><label for='opt14'>UK 12.0</label>
                                <input type='radio' name='Size' value='UK 12.5' class='size-btn' id='opt15'/><label for='opt15'>UK 12.5</label>
                                <input type='radio' name='Size' value='UK 13.0' class='size-btn' id='opt16'/><label for='opt16'>UK 13.0</label>
                                <input type='radio' name='Size' value='UK 14.0' class='size-btn' id='opt17'/><label for='opt17'>UK 14.0</label></center></td></tr>";
        }else if($category == "clothes" || $category == "pant"){
            echo "<tr><td height='50px'>";
                                echo "<center><input type='radio' name='Size' class='size-btn' value='XS' id='opt1'/><label for='opt1'>XS</label> 
                                <input type='radio' name='Size' class='size-btn' value='S' id='opt2'/><label for='opt2'>S</label> 
                                <input type='radio' name='Size' class='size-btn' value='M' id='opt3'/><label for='opt3'>M</label> 
                                <input type='radio' name='Size' class='size-btn' value='L' id='opt4'/><label for='opt4'>L</label>
                                <input type='radio' name='Size' class='size-btn' value='XL' id='opt5'/><label for='opt5'>XL</label>
                                <input type='radio' name='Size' class='size-btn' value='2XL' id='opt6'/><label for='opt6'>2XL</label>
                                <input type='radio' name='Size' class='size-btn' value='3XL' id='opt7'/><label for='opt7'>3XL</label></center>
                        </td></tr>";
        }
                ?>
        
        <tr>
            <td height="50px">
        <center>
                <input type='submit' value='Update' class="editBtn" name='editBtn' />
                <input type='reset' value='Reset' class='resetBtn' name='resetBtn' />
        </center>
        </td>
        </tr>
    </table>
            </center>
</form>
        <br/>
        <?php endif; 
        include './footer1.php';
        ?>
        
    </body>
</html>
