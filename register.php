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
                    <span id="error"></span>
                    <form method="post" id="user_form">
                        <div class="mb-3">
                            <label for="" class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="First Name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">User Name</label>
                            <input type="text" name="username" class="form-control" placeholder="User Name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" name="user_email" class="form-control" placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Password</label>
                            <input type="password" name="user_password" class="form-control" placeholder="Password">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Password Confirmation</label>
                            <input type="password" name="user_pass_conf" class="form-control" placeholder="Password Confirmation">
                        </div>
                        <div class="my-4" style="font-size: 14px;">
                            By signing up, I agree with the <a href="">terms & condition</a> of the website.
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="action" value="Register">
                            <input type="submit" class="btn btn-primary form-control" id="submit_button" value="Register">
                        </div>
                        <span id="message"></span>
                    </form>
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

        $('#user_form').on('submit', function(event){

	    	event.preventDefault();

	    	$.ajax({
	    		url:"login_register_action.php",
	    		method:"POST",
	    		data:$(this).serialize(),
	    		dataType:'json',
	    		beforeSend:function()
	    		{
	    			$('#submit_button').attr('disabled', 'disabled');
	    			$('#submit_button').val('wait...');
	    		},
	    		success:function(data)
	    		{
	    			$('#submit_button').val('Done');
            if(data.error != '')
            {
                $('#error').html(data.error);
                $('#submit_button').removeAttr('disabled');
                $('#submit_button').val('Register');

                setTimeout(function(){
                
                $('#error').html('');
                
                }, 5000);
            }
            else
            {
                window.location.href = 'student_dashboard.php';

            }
	    		}
	    	})
	    });
    });
  </script>


</body>

</html>