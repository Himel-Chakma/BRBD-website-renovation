<?php
include('admin/main.php');
$object = new brbd();
$user_id = '';
$display = 'none';
if(isset($_SESSION["user_id2"]))
{
  $user_id = $_SESSION["user_id2"];
  $display = 'block';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="img/png" href="img/logo.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bstyle.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <title>BRBD</title>
</head>

<style>
  @font-face {
		font-family: myfont;
		src: url(SolaimanLipi.ttf);
	}
  a {
    text-decoration: none;
  }
  a.active {
    border-bottom: 2px solid #007bff;
  }
  .card-title a:hover {
    color: #007bff !important;
  }
  .course {
    transition: transform 0.5s ease-in-out;
  }
  .course:hover {
    transform: translateY(-7px);
    transition: transform 0.5s ease-in-out;
  }
  .parallax {
    height: 300px;
    background-image: url('img/people-office.jpg');
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }
  .overlayer {
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
  }
  .mover {
      width: 100%;
      overflow-x: auto;
      scroll-snap-type: x mandatory;
      scroll-behavior: smooth;
      scrollbar-width: none;
  }
  .mover::-webkit-scrollbar {
      display: none;
  }
  .mover.no-transition {
      scroll-behavior: auto;
  }
  .mover.dragging {
      scroll-snap-type: none;
      scroll-behavior: auto;
  }
  .body {
      display: flex;
      width: max-content;
      padding-left: 16px;
  }
  .navig {
      position: absolute;
      z-index: 10;
      top: 100px;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      cursor: pointer;
      border: none;
      outline: none;
      background-color: white;
      box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.3);
      font-size: 18px;
  }
  .navig.right {
      right: 16px;
  }
  .navig.left {
      left: 16px;
      opacity: 0;
  }
</style>

<body>
    	<?php
      include('navbar.php');
    ?>
    

    <div class="container" style="text-align: center;">

        <h1 class="py-3"><b>OUR PUBLISHES BLOG</b></h1>
     
        <div class="box-container">
     
           <div class="box">
              <div class="image">
                 <img src="img/1.jpg" alt="">
              </div>
              <div class="content">
                 <h3>blog title goes here</h3>
                 <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                 <a href="#" class="btn">read more</a>
                 <div class="icons">
                    <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                    <span> <i class="fas fa-user"></i> by admin </span>
                 </div>
              </div>
           </div>
     
           <div class="box">
              <div class="image">
                 <img src="img/2.jpg" alt="">
              </div>
              <div class="content">
                 <h3>blog title goes here</h3>
                 <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                 <a href="#" class="btn">read more</a>
                 <div class="icons">
                    <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                    <span> <i class="fas fa-user"></i> by admin </span>
                 </div>
              </div>
           </div>
     
           <div class="box">
              <div class="image">
                 <img src="img/3.jpg" alt="">
              </div>
              <div class="content">
                 <h3>blog title goes here</h3>
                 <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                 <a href="#" class="btn">read more</a>
                 <div class="icons">
                    <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                    <span> <i class="fas fa-user"></i> by admin </span>
                 </div>
              </div>
           </div>
     
           <div class="box">
              <div class="image">
                 <img src="img/1.jpg" alt="">
              </div>
              <div class="content">
                 <h3>blog title goes here</h3>
                 <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                 <a href="#" class="btn">read more</a>
                 <div class="icons">
                    <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                    <span> <i class="fas fa-user"></i> by admin </span>
                 </div>
              </div>
           </div>
     
           <div class="box">
              <div class="image">
                 <img src="img/2.jpg" alt="">
              </div>
              <div class="content">
                 <h3>blog title goes here</h3>
                 <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                 <a href="#" class="btn">read more</a>
                 <div class="icons">
                    <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                    <span> <i class="fas fa-user"></i> by admin </span>
                 </div>
              </div>
           </div>
     
           <div class="box">
              <div class="image">
                 <img src="img/3.jpg" alt="">
              </div>
              <div class="content">
                 <h3>blog title goes here</h3>
                 <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                 <a href="#" class="btn">read more</a>
                 <div class="icons">
                    <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                    <span> <i class="fas fa-user"></i> by admin </span>
                 </div>
              </div>
           </div>
     
           <div class="box">
              <div class="image">
                 <img src="img/logo.png" alt="">
              </div>
              <div class="content">
                 <h3>blog title goes here</h3>
                 <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                 <a href="#" class="btn">read more</a>
                 <div class="icons">
                    <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                    <span> <i class="fas fa-user"></i> by admin </span>
                 </div>
              </div>
           </div>
     
           <div class="box">
              <div class="image">
                 <img src="img/sir.jpg" alt="">
              </div>
              <div class="content">
                 <h3>blog title goes here</h3>
                 <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                 <a href="#" class="btn">read more</a>
                 <div class="icons">
                    <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                    <span> <i class="fas fa-user"></i> by admin </span>
                 </div>
              </div>
           </div>
     
           <div class="box">
              <div class="image">
                 <img src="img/Alam.jpg" alt="">
              </div>
              <div class="content">
                 <h3>blog title goes here</h3>
                 <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                 <a href="#" class="btn">read more</a>
                 <div class="icons">
                    <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                    <span> <i class="fas fa-user"></i> by admin </span>
                 </div>
              </div>
           </div>
     
        </div>
     
        <div id="load-more"> load more...</div>
     
     </div>
     
     

   <br><br>

    <?php
    include("footer.php");
    ?>

     <!-- Bootstrap core JavaScript-->
<script src="admin/vendor/jquery/jquery.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="admin/vendor/jquery-easing/jquery.easing.min.js"></script>
     
     <script>
     
     $(document).ready(function() {

        $('#blog').toggleClass('active');
    
     });
     
     let loadMoreBtn = document.querySelector('#load-more');
     let currentItem = 3;
     
     loadMoreBtn.onclick = () =>{
        let boxes = [...document.querySelectorAll('.container .box-container .box')];
        for (var i = currentItem; i < currentItem + 3; i++){
           boxes[i].style.display = 'inline-block';
        }
        currentItem += 3;
     
        if(currentItem >= boxes.length){
           loadMoreBtn.style.display = 'none';
        }
     }
     
     </script>



</body>

</html>