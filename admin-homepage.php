<html>
    <head>
        <meta charset="UTF-8">
        <title>ADMIN HOMEPAGE</title>
        <link href="css/admin-homepage.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image:url(images/3.jpg);">
         <?php include './adminHeader1.php'; ?>
        
  <div class="slideshow-container" style="margin-top:30px;margin-bottom:30px;margin-left:250px;">
  
  <div class="mySlides fade">
    <img src="images/slide1.png" style="width:80%; height: 500px;">
  </div>
  
  <div class="mySlides fade">
    <img src="images/slide2.png" style="width:80%; height: 500px;">
  </div>
  
  <div class="mySlides fade">
    <img src="images/slide3.jpg" style="width:80%; height: 500px;">
  </div>

  </div>
        
   <br>
  
  <div style="text-align:center">
    <span class="dot"></span> 
    <span class="dot"></span> 
    <span class="dot"></span> 
    <span class="dot"></span>
  </div>
   
  
    </body>
    
     <script>
    /*SLIDESHOW*/
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
