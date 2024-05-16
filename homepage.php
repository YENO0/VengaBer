<html>
    <head>
        <meta charset="UTF-8">
        <title>Homepage</title>
        <link href="homepage.css" rel="stylesheet" type="text/css"/>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.1.8.3.min.js"></script>
        <script src="js/site.js"></script>
        <link href="css/animate.css" rel="stylesheet" type="text/css"/>
    </head>
    
    <body style="background-image: url('image./background_3.jpg'); 
          background-repeat: no-repeat; background-size: cover; 
          background-position: center; height: 4200px;">   
     <?php include './header1.php'; ?>

  <div class="slideshow-container" style="margin-top:30px;margin-bottom:30px;margin-left:250px;">
  
  <div class="mySlides fade">
    <img src='images/slide1.png' style="width:80%; height: 500px;">
  </div>
  
  <div class="mySlides fade">
    <img src="images/slide2.png" style="width:80%; height: 500px;">
  </div>
      
  <div class="mySlides fade">
    <img src="images/slide3.jpg" style="width:80%; height: 500px; object-fit: cover;">
  </div>

  </div>
        
   <br>
  
  <div style="text-align:center">
    <span class="dot"></span> 
    <span class="dot"></span> 
    <span class="dot"></span> 
    <span class="dot"></span>
  </div>
   
    <h1 style="padding-left: 135px;">Flower Categories</h1>
    <center>
   <table class='homepage_table'>
       <tr class='homepage_tr wow fadeInUp'>
           <?php
           (isset($_GET['user_id']))?
           $userID = trim($_GET['user_id']):
           $userID = "";
           echo "<td class='homepage_td'><a href='./flowers_gypsophila.php?user_id=$userID' class='homepage_a'><img src='image/gypsophila1a.jpg' height='250'/><br/><br/>View More Details &#128073;</a></td>";
           echo "<td class='homepage_td'><a href='./flowers_mixedFlower.php?user_id=$userID' class='homepage_a'><img src='image/mixedflower1a.jpg' height='250'/><br/><br/>View More Details &#128073;</a></td>";
           echo "<td class='homepage_td'><a href='./flowers_sunflower.php?user_id=$userID' class='homepage_a'><img src='image/sunflower1a.jpg' height='250'/><br/><br/>View More Details &#128073;</a></td>";
           echo "<td class='homepage_td'><a href='./flowers_tulip.php?user_id=$userID' class='homepage_a'><img src='image/tulip1a.jpg' height='250'/><br/><br/>View More Details &#128073;</a></td>";
           echo "<td class='homepage_td'><a href='./flowers_twistStick.php?user_id=$userID' class='homepage_a'><img src='image/twiststick1a.jpg' height='250'/><br/><br/>View More Details &#128073;</a></td>";
           ?>
       </tr>
   </table>
    </center>
    <br><br><h1 style="padding-left: 135px;">All Flowers</h1><br>
    <div style="max-width: 1245px; padding: 0 85px; margin: 0 auto;">
    <table class="product2">
            <form method="post" action="">
                <div class="products-container">
                <?php
define('DB_HOST', "yy-ver1-rds.ctqigw62kpxk.us-east-1.rds.amazonaws.com");
define('DB_USER', "yen0809");
define('DB_PASS', "p3TEr100");
define('DB_NAME', "PETER");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sql = "SELECT * FROM products";
if ($result = $con->query($sql)) {
    echo "<div class='products-container'>";
    while ($record = $result->fetch_object()) {
        (isset($_GET['user_id'])) ?
        $userID = trim($_GET['user_id']) : $userID = "";
        printf("
            <div class='product wow fadeInUp' style='border-radius: 4px;'>
                <a href='twistStick.php?id=%s&user_id=%s'><img src='uploaded_img/%s' height='350' alt='' class='product_img'></a>
                <div class='product-details'>
                    <span class='product-name'>%s</span><br><br>
                    <span class='product-price'>RM %s.00</span><br><br>
                    <a href='twistStick.php?id=%s&user_id=%s' class='product-link'>View More Details &#128073;</a>
                </div>
            </div>",
            $record->id,
            $userID,
            $record->image1,
            $record->name,
            $record->price,
            $record->id,
            $userID
        );
    }
    echo "</div>";
    $result->free();
    $con->close();
}
?>
                </div>
            </form>
        </table>
    </div>
       <?php include './footer1.php'; ?>

   </body>
   
   
    <script>
    /SLIDESHOW/
    let slideIndex = 0;
    showSlides();
    
    function showSlides() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 4000); // Change image every 4 seconds
    }
    </script>
</html>
