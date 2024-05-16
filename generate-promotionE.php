<html>
    <head>
        <meta charset="UTF-8">
        <title>EDIT PROMOTION</title>
        <link href="css/promotion.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image:url('images/3.jpg');background-size:cover;background-repeat:no-repeat;">
        <?php 
        include './adminHeader1.php';
        require_once './config/database.php';
        ?>
        
        <center><h1>EDIT PROMOTION CODE</h1></center>
        
        
        <?php
        global $hideForm;
        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            
            (isset($_GET['PromotionCode']))?
            $PromotionCode = strtoupper(trim($_GET['PromotionCode'])):$PromotionCode = "";
            //Step 1: connection
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            //STEP 2: SQL statement
            $sql = "SELECT * FROM promotiong WHERE PromotionCode = '$PromotionCode'";
            
           if($result = $con->query($sql))
              {            
                while($record = $result->fetch_object()){
                
                  $promotionF = $record->PromotionF;
                  $PromotionCode = $record->PromotionCode;
                  $description = $record->DescriptionP; 
                  $promotionP = $record->PromotionP;
                }
              $result->free();
              $con->close(); 
            }else{
                //record not found
                echo "<div class='error'>Unable to retrieve record! [ <a href='generate-promotion.php'>Back to list</a> ]</div>";
                
                $hideForm = true;
            }
            
        }else{
            
        $PromotionCode = strtoupper(trim($_POST['hdCode']));
        $description = trim($_POST['PromotionD']);
        $promotionF = trim($_POST['promotionF']);
        $promotionP = trim($_POST['promotionP']) ;
            
           
            //check if $error contains message
            if(empty($error)){
                //no errpr, can UPDATE record
                //Step 1: establish connection
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
                //STEP 2: sql statement
               $sql = "UPDATE promotiong SET PromotionF = ?, DescriptionP = ? , PromotionP = ? WHERE PromotionCode = ?";

                
                //STEP 3: run sql
                //NOTE: when we hard code sql,
                //$con-query()
                //when we use "?", $con->prepare()
                $stmt = $con->prepare($sql);
                $stmt->bind_param('ssss', $promotionF, $description, $PromotionCode,$promotionP);

                
                if($stmt->execute()){
                    //record edited
                    echo "<div class='info'>Promotion <b>$PromotionCode</b> has been edited. [ <a href='generate-promotion.php'>Back to list</a> ]</div>";
                }else{
                    //unable to edit
                    echo "<div class='error'>Unable to edit. Please try again.</div>";
                }
                $con->close();
                $stmt->close();
            }else{
                //with error, display error message
                echo "<ul class='error'>";
                foreach ($error as $value){
                    echo "<li>$value</li>";
                }
                echo "</ul>";
            }
        }
        ?>
        <?php if($hideForm == false): ?>
        <form method='POST' action=''>
            <table>
                <tr>
                    <td>Promotion Code:</td>
                    <td><?php echo $PromotionCode; ?><input type='hidden' name='hdCode' value='<?php echo $PromotionCode ?>' /></td>
                </tr>
                <tr>
                    <td>Promotion Description: </td>
                    <td><input type='text' name='PromotionD' value='<?php echo $description; ?>' /></td>
                </tr>
                <tr>
                    <td>Promotion For: </td>
                    <td><input type='text' name='promotionF' value='<?php echo $promotionF; ?>' /></td>
                </tr>
                
                <tr>
                    <td>Promotion For: </td>
                    <td><input type='text' name='promotionP' value='<?php echo $promotionP; ?>' /></td>
                </tr>
            </table>
            <button type='submit'>Save</button>     
                <button type='reset' onclick="location='generate-promotion.php'">Cancel</button>
            </form>
        <?php endif; ?>
    </body>
</html>