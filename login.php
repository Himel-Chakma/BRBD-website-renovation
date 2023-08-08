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
        <div class="row">
            <div class="col-md-5 m-auto">
                <div class="card card-body m-auto p-5 my-5">
                    <h4>Hi, Welcome Back</h4>
                    <span id="error"></span>
                    <form method="post" id="login_form" class="mt-3">
                        <div class="form-group mb-3">
                            <input type="text" name="useremail" class="form-control" id="" placeholder="Enter Your Email">
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="passcode" class="form-control" id="" placeholder="Enter Password">
                        </div>
                        <div class="form-group mb-3">
                            <input type="hidden" name="action" value="login">
                            <input type="submit" class="btn btn-primary form-control" id="login_button" value="Sign In">
                        </div>
                    </form>
                    <div class="text-center"><a href="password_recovery.php" class="text-decoration-none text-primary">Forgot Password?</a></div>
                    <div class="text-center pt-3">
                        Don't have an account? <a href="register.php" class="text-decoration-none text-primary">Register Now</a>
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

$(document).ready(function(){

    $('#login').toggleClass('active');

    $('#login_form').on('submit', function(event){
        event.preventDefault();
     
        $.ajax({
            url:"login_register_action.php",
            method:"POST",
            data:$(this).serialize(),
            dataType:'json',
            beforeSend:function()
            {
                $('#login_button').attr('disabled', 'disabled');
                $('#login_button').val('wait...');
            },
            success:function(data)
            {
                $('#login_button').attr('disabled', false);
                if(data.error != '')
                {
                    $('#error').html(data.error);
                    $('#login_button').val('Login');
                }
                else
                {
                    window.location.href = "student_dashboard.php";
                }
            }
        })
    });

});

</script>
</body>

</html>