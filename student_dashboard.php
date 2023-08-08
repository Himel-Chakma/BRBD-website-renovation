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
  ul.custom-style {
      width: 100% !important;
  }
  ul.custom-style li a {
      padding-left: 16px !important;
      color: #000;
  }
  ul.custom-style li a i {
      color: #007bff;
      width: 20px;
  }
  ul.custom-style li a.active2 {
      background-color: #007bff;
      color: #fff;
      border-top-left-radius: 6px;
      border-bottom-left-radius: 6px;
  }
  ul.custom-style li a.active2 i {
    color: #fff;
  }
  .icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background-color: #cfe4fa;
    color: #007bff;
    font-size: 24px;
  }
</style>

<body>
    <?php
      include('navbar.php');
    ?>
    
   <div class="container p-0 mb-5">

    <?php
    include('profile_heading.php');
    ?>

    <div class="row ps-4">
        <div class="col-md-3 m-0 p-0 border-end">
            <nav class="navbar navbar-expand-lg my-3 p-0">
              <div class="container m-0 p-0">
                <button class="navbar-toggler mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav2">
                  <ul class="navbar-nav d-flex flex-column custom-style m-0 p-0">
                    <li class="nav-item">
                      <a class="nav-link active2" href="student_dashboard.php"><i class="fa-solid fa-gauge-high me-2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="student_profile.php"><i class="fa-solid fa-user me-2"></i> My Profile</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="student_course_enrolled.php"><i class="fa-solid fa-graduation-cap me-2"></i> Enrolled Courses</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="student_review.php"><i class="fa-solid fa-star me-2"></i> Reviews</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="student_quiz.php"><i class="fa-solid fa-dice me-2"></i> My Quiz Attempts</a>
                    </li>
                    <?php
                        $object->query = "SELECT * FROM instructors WHERE student_id = '$user_id' AND instructor_status = 'Approved'";

                        $object->execute();

                        if($object->row_count() > 0)
                        {
                          echo '
                          <hr class="my-2">
                          <h6 class="text-secondary ms-3">INSTRUCTOR</h6>
                          <li class="nav-item">
                            <a class="nav-link" href="instructor_courses.php"><i class="fa-solid fa-book-open-reader me-2"></i> My Courses</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="assignments.php"><i class="fa-solid fa-clipboard-list me-2"></i> Assignments</a>
                          </li>
                          ';
                        }
                    ?>
                    <hr class="my-2">
                    <li class="nav-item">
                      <a class="nav-link" href="student_settings.php"><i class="fa-solid fa-gear me-2"></i> Settings</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
        </div>
        <div class="col-md-9 m-0 p-4">
            <div class="container m-0 p-0">
              <h4 class="mb-4">Dashbord</h4>
              <div class="row">
                <div class="col-md-4">
                  <div class="card card-body py-4 mb-3">
                    <div class="d-flex justify-content-center flex-column align-items-center">
                        <div class="icon d-flex justify-content-center align-items-center"><i class="fa-solid fa-book-open"></i></div>
                        <h3 class="my-3"><div class="counter"><?php echo $object->fetch_count($user_id, 'Enrolled'); ?></div></h3>
                        Enrolled Courses
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card card-body py-4 mb-3">
                    <div class="d-flex justify-content-center flex-column align-items-center">
                        <div class="icon d-flex justify-content-center align-items-center"><i class="fa-solid fa-graduation-cap"></i></div>
                        <h3 class="my-3"><div class="counter"><?php echo $object->fetch_count($user_id, 'Running'); ?></div></h3>
                        Active Courses
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card card-body py-4 mb-3">
                    <div class="d-flex justify-content-center flex-column align-items-center">
                        <div class="icon d-flex justify-content-center align-items-center"><i class="fa-solid fa-trophy"></i></div>
                        <h3 class="my-3"><div class="counter"><?php echo $object->fetch_count($user_id, 'Completed'); ?></div></h3>
                        Completed Courses
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card card-body py-4 mb-3">
                    <div class="d-flex justify-content-center flex-column align-items-center">
                        <div class="icon d-flex justify-content-center align-items-center"><i class="fa-solid fa-book-open-reader"></i></div>
                        <h3 class="my-3"><div class="counter">
                          <?php
                            $object->query = "SELECT courses.*, instructors.* FROM courses INNER JOIN instructors ON courses.course_author = instructors.instructor_id WHERE instructors.student_id = '$user_id'";

                            $object->execute();
                            
                            echo $object->row_count();
                          ?>
                        </div></h3>
                        Created Courses
                    </div>
                  </div>
                </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>

<script>

$(document).ready(function(){

    // $('.counter').counterUp({
    //   delay: 10,
    //   time: 120
    // });
    $(document).on('click', '#instructor_request', function() {
    
    var student_id = $(this).data('id');
    
      $.ajax({
      
          url:"instructor_action.php",
      
          method:"POST",
      
          data:{student_id: student_id, action:'instructor_request'},
      
          dataType:'JSON',
        
          success:function(data)
          {
              $('#instructor_control').html('<i class="fa-solid fa-circle-exclamation me-2 text-warning"></i> Your Application is pending as of <span class="fw-bold">'+data+'</span>');
          }
      })
    
    });
    
});

</script>
</body>

</html>