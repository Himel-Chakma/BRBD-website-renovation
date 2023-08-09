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
    <link rel="shortcut icon" type="img/png" href="img/1.jpg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <title>BRBD</title>
</head>

<style>
    @font-face {
		font-family: myfont;
		src: url(SolaimanLipi.ttf);
	}
  a.active {
    border-bottom: 2px solid #007bff;
  }
  .custom_style {
    width: 40%;
  }
</style>

<body>
    <?php
      include('navbar.php');
    ?>
    
    <div class="container">
        <div class="row m-auto">
            <div class="col-md-7 m-auto p-3">
            <a href=""><img src="img/logo2.png" class="img-fluid" width="150"></a>
            <p class="my-4">
            <i class="fa-solid fa-mobile-screen-button"></i>
            <span class="text-primary fs-5 fw-bold"> 0163473737, 01717153698</span> <br>
            <i class="fa-solid fa-envelope"></i>
            <span class="text-primary fs-5 fw-bold">beresearcherbd@gmail.com</span>
            </p>
            <p>
            58 Howard Street #2 San Francisco<br>contact@edumall.com
            </p>
            <p class="d-flex fs-5">
              <a href="" class="me-4 text-decoration-none text-reset"><i class="fa-brands fa-facebook-f" style="color: #1877F2;"></i></a>
              <a href="" class="me-4 text-decoration-none text-reset"><i class="fa-brands fa-youtube" style="color: #FF0000;"></i></a>
              <a href="" class="me-4 text-decoration-none text-reset"><i class="fa-brands fa-skype" style="color: #00AFF0;"></i></a>
              <a href="" class="me-4 text-decoration-none text-reset"><i class="fa-brands fa-linkedin-in" style="color: #0077B5;"></i></a>
            </p>
            </div>
            <div class="col-md-5">
                <div class="card card-body m-auto p-5 my-5">
                    <h3>Send Message</h3>
                    <span id="error"></span>
                    <form method="post" id="contact_form" class="mt-3">
                        <div class="form-group mb-3">
                            <input type="text" name="useremail" class="form-control" id="" placeholder="Enter Your Email">
                        </div>
                        <div class="mb-3">
                        <!-- <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label> -->
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter Your Message"></textarea>
                       </div>
                       <div>
                       <input class="btn btn-primary" type="submit" value="Submit">
                       </div>
                </div>
            </div>
        </div>
    </div>

   
    
    

    <?php
    include("footer.php");
    ?>

    <!-- Bootstrap core JavaScript-->
<script src="admin/vendor/jquery/jquery.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="admin/vendor/jquery-easing/jquery.easing.min.js"></script>

<script>
    $(document).ready(function() {

        $('#contact').toggleClass('active');
        
    });
</script>

</body>

</html>