<?php
define('DB_HOST', "yy-ver1-rds.ctqigw62kpxk.us-east-1.rds.amazonaws.com");
define('DB_USER', "yen0809");
define('DB_PASS', "p3TEr100");
define('DB_NAME', "PETER");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM review_table WHERE review_id = $id");
    header('location:list_review.php');
};

function getStar(){
    return array(
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5'
    );       
}
$con->close();
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>List Review</title>
        <link href="css/style.css" 
              rel="stylesheet" 
              type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>
    <body style="background-image:url(images/3.jpg);background-size: cover;background-repeat: no-repeat;">
        <?php
        include './adminHeader1.php';

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        
        $header = array(
            'user_name ' => 'User Name',
            'user_rating' => 'User Rating',
            'user_review'  => 'User Review'
        );
        
        global $sort, $order;
        if (isset($_GET['sort']) && isset($_GET['order'])){
        $sort = (array_key_exists($_GET['sort'], $header)?
                $_GET['sort'] : 'review_id');
        
        //how to arrange order sequence ASC/DESC
        $order = ($_GET['order']=='DESC')? 'DESC' : 'ASC';
        }else{
            $sort="review_id";
            $order="ASC";
        }
        if(isset($_GET["star"])){
        $star = (array_key_exists($_GET["star"], 
                getStar())? $_GET["star"] : "%");
        }else{
            $star = "%";
        }

        
        ?>
        <div><a href="admin_review.php" class="list_title">Back</a></div>
        <h1 class="list_h1">List Review</h1>
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
                $sql = "DELETE FROM review_table WHERE review_id IN('".implode("','", $esChecked) ."')";
                
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
            
                All Stars</a>",$sort, $order);
        
        $allStar = getStar(); //array
        foreach($allStar as $key => $value){
            printf("
                | <a href='?sort=%s&order=%s&star=%s' class='review_filter2'>%s Star</a>
                    ",$sort, $order, $key, $value);
        }
        
        ?>
        </div>
        <form action="" method="post">
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
                              <a href="?sort=%s&order=%s&star=%s"  class="review_th">%s</a>
                              %s
                            </th>'
                            ,$key
                            ,$order == 'ASC' ? 'DESC' : 'ASC'
                            ,$star
                            ,$value
                            ,$order == 'ASC' ? '⬇' : '⬆');
                    }else{
                        //NO, user never click anythin, default
                        printf('<th>
                            <a href="?sort=%s&order=ASC&star=%s"  class="review_th">%s</a>
                                </th>'
                                ,$key
                                ,$star
                                ,$value);
                    }
                }
                ?>
            <th>Action</th>
        </tr>
    </thead>
        <?php 

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sql = "SELECT * FROM review_table WHERE user_rating LIKE '$star' ORDER BY $sort $order";

if($result = $con->query($sql)){
                while($record = $result->fetch_object()){
                        printf("
                        <tr>
                        <td><input type='checkbox' name='checked[]' value='%s' style='width:20px; height: 20px;'/></td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>
                        <a href='edit_review.php?edit=%s' class='btn'><i class='fas fa-edit'></i>Edit</a>
                        <a href='list_review.php?delete=%s' class='btn'><i class='fas fa-trash'></i>delete</a>
                        </td>
                        </tr>

                            ",$record->review_id,
                              $record->user_name,
                              getStar()[$record->user_rating],
                              $record->user_review,
                              $record->review_id,
                              $record->review_id);
                }
            } 
            $con->close();
?>
                </table>
        </div>
            <input type="submit" value="Delete Checked" name="btnDeleteChecked" class="deleteBtn" 
                   onclick="return confirm('This will delete all checked records.\n Are you sure?')"/> 
        </form>
    </body>
</html>
