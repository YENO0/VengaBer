<html>
    <head>
        <meta charset="UTF-8">
        <title>DELETE PROMOTION</title>
        <link href="css/promotion.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image:url('images/3.jpg');background-size:cover;background-repeat:no-repeat;">
        
        <?php include './adminHeader1.php';
           require_once './config/database.php';?>
        
    <center><h1>DELETE PROMOTION</h1></center>
    
    <?php
    if($_SERVER["REQUEST_METHOD"]=="GET"){
           
            (isset($_GET["PromotionCode"]))?
            $code = strtoupper(trim($_GET["PromotionCode"])):
            $code = "";
            
        $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        
        $code = $con->real_escape_string($code);
        
        $sql = "SELECT * FROM promotiong WHERE PromotionCode = '$code'";
            
        $result = $con->query($sql);
        if(mysqli_num_rows($result) > 0){
        if($record=$result->fetch_object()){
            $promotionF=$record->PromotionF;
            $code=$record->PromotionCode;
            $promotionD=$record->DescriptionP;
            $promotionP=$record->PromotionP;
            
            printf("<p>Are you sure you want to delete this ?</p>
                         <table>
                         <tr>
                         <td>Promotion For:</td>
                         <td>%s</td>
                         </tr>
                         <tr>
                         <td>Promotion Code:</td>
                         <td>%s</td>
                         </tr>
                         <tr>
                         <td>Description:</td>
                         <td>%s</td>
                         </tr>
                         <tr>
                         <td>Promotion Percentage:</td>
                         <td>%.1lf</td>
                         </tr>
                         </table>
                         <form action='' method='POST'>
                         <button type='submit'>Delete</button>     
        <button type='reset' onclick='location=\"generate-promotion.php\"'>Cancel</button>
                         <input type='hidden' name='hdCode' value='%s' />
                         </form>",$promotionF,$code,$promotionD,$promotionP,$code);
        }
        }else{
            echo"<div>
                     Unable to retrieve record![<a href='generate-promotion.php'>Back To List</a>]
                     </div>";
        }
        $con->close();
        $result->free(); 
    }else{
        $code = strtoupper(trim($_POST["hdCode"]));
        
        $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        
        $sql ="DELETE FROM promotiong WHERE PromotionCode = ?";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s",$code);
            
        $stmt->execute();
        
        if($stmt->affected_rows>0){
                //record deleted
                echo"<div>
                     Promotion has been deleted.[<a href='generate-promotion.php'> Back To List</a>]
                     </div>";
            }else{
                //unable to delete
                 echo"<div class='error'>
                     Unable to delete record![<a href='generate-promotion.php'>Back To List</a>]
                     </div>";
            }
    }
    ?>
    </body>
</html>