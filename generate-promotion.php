<html>
    <head>
        <meta charset="UTF-8">
        <title>GENERATE PROMOTION</title>
        <link href="css/promotion.css" rel="stylesheet" type="text/css"/>
    </head>
    
    <body style="background-image:url('images/3.jpg');background-size:cover;background-repeat:no-repeat;">
        
     <?php include './adminHeader1.php';
           require_once './config/database.php';?>
        
    <h1>Generate Promotion Code</h1>
    
    <?php
    if(!empty($_POST)){
        $code = trim($_POST['Pcode']);
        $promotionF = trim($_POST['PromotionF']);
        $promotionD = trim($_POST['PromotionD']);
        $promotionP = trim($_POST['PromotionP']);
        
        $error['code'] = promotionCode($code);
        
        $error = array_filter($error);
        
        if(empty($error)){
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
            $sql = "INSERT INTO promotiong (PromotionF, PromotionCode, DescriptionP,PromotionP) VALUES (?,?,?,?)";
            
            $stmt = $con->prepare($sql);
            $stmt->bind_param('ssss', $promotionF, $code, $promotionD,$promotionP);
            
            $stmt->execute();
            
            if($stmt->affected_rows>0){
                //record inserted
                    echo"<div><b>$promotionF</b> promotion has been inserted.</div>";
                    //reset field 
                    $code=$promotionF=$promotionD=$promotionP=null;
            }else{
                echo "<div> Unable to insert. Please try again! </div>";
            }
            $stmt->close();
            $con->close();
        }else{
            echo "<ul>";
                foreach ($error as $value){
                    echo "<li>$value</li>";
                }
                echo "</ul>";
        }
    }
    ?>
    
    <form method="POST" enctype="multipart/form-data">
        
        <label for="name">Promotion Code:</label>
        <input type="text" id="code" name="Pcode" required><br><br>
        
        <label for="name">Promotion For:</label>
        <input type="text" id="purpose" name="PromotionF" required><br><br>

        <label for="price">Promotion Description:</label>
        <input type="text" id="description" name="PromotionD" required><br><br>
        
        <label for="price">Promotion Percentage:</label>
        <input type="text" id="percentage" name="PromotionP" min="0" required><br><br>

        <button type="submit">Add Promotion</button>     
        <button type="reset" onclick="location='generate-promotion.php'">Cancel</button>
            
    </form>
    
    <br/><br/>
    
   <?php 
   $header=array('Promotion For' => 'Promotion For',
                 'Promotion Code' => 'Promotion Code',
                 'Promotion Details' =>'Promotion Details',
                 'Promotion Percentage'=>'Promotion Percentage',
                 'Action' =>'Action');
   ?>
    
    <table>
        <tr>
            <?php
            foreach($header as $key => $value)
            printf('<th>%s</th>',$value);
            ?>
        </tr>    
        
        <tbody>
            <?php
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            //Step 3: SQL statement
            $sql = "SELECT * FROM promotiong";
            
            //Step 4: run sql
            //NOTE: $result - contains all records
            if($result = $con->query($sql)){
                while($record = $result->fetch_object()){
                    printf("
                        <tr>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%.1lf</td>
                        <td>
                        <a href='generate-promotionE.php?PromotionCode=%s'>
                        <input type='button' value='&#128221; Edit' name='edit' class='btnEdit'></input>
                        </a>
                        <br/><br/>
                        <a href='generate-promotionD.php?PromotionCode=%s'>
                        <input type='button' value='&#x1F5D1;&#xFE0F; Delete' name='delete' class='btnDelete'></input>
                        </a>
                        </td>
                        </tr>
                        ",$record->PromotionF
                         ,$record->PromotionCode
                         ,$record->DescriptionP
                         ,$record->PromotionP
                         ,$record->PromotionCode
                         ,$record->PromotionCode);        
                }
                 $result->free();
                 $con->close();
            }
            ?>
        
    </table>
</body>
</html>



