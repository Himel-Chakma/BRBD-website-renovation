<?php
include('admin/main.php');
$object = new brbd();

if(!isset($_SESSION["user_id2"]))
{
  header("location:index.php");
}
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
  .student_name {
    top: 40%;
  }
  .course_name {
    top: 60%;
  }
  .certificate_ID {
    top: 85%;
    left: 5%;
  }
</style>

<body>
    <?php
      include('navbar.php');
    ?>
    
    <div class="container">
        <div class="row">
            <div class="col-md-8 p-0 m-auto my-3 position-relative">
              <?php
                $object->query = "
                SELECT `students`.`student_first_name`, `students`.`student_last_name`, `course_enrolled`.`certificate_id`, `courses`.`course_certificate`, `courses`.`course_title` 
                FROM `students` 
                  LEFT JOIN `course_enrolled` ON `course_enrolled`.`student_id` = `students`.`student_id` 
                  LEFT JOIN `courses` ON `course_enrolled`.`course_id` = `courses`.`course_id`
                WHERE `course_enrolled`.`student_id` = '".$_SESSION["user_id2"]."' AND `course_enrolled`.`course_id` = '".$_SESSION["course_id"]."';
                ";

                $result = $object->get_result();

                foreach($result as $row)
                {
                  echo '
                  <div class="student_name position-absolute" style="width: 100%;"><h2 class="m-0 text-center">'.$row["student_first_name"].' '.$row["student_last_name"].'</h2></div>
                  <div class="course_name position-absolute" style="width: 100%;"><h2 class="m-0 text-center">'.$row["course_title"].'</h2></div>
                  <div class="certificate_ID position-absolute">
                      Valid Certificate ID <br>
                      <span class="fw-bold">'.$row["certificate_id"].'</span>
                  </div>
                  <img src="admin/'.$row["course_certificate"].'" class="img-fluid">
                  ';
                }
              ?>
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

    

});

</script>
</body>

</html>