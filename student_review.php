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

  .rating-color{
      color:#fbc634 !important;
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
                      <a class="nav-link" href="student_dashboard.php"><i class="fa-solid fa-gauge-high me-2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="student_profile.php"><i class="fa-solid fa-user me-2"></i> My Profile</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="student_course_enrolled.php"><i class="fa-solid fa-graduation-cap me-2"></i> Enrolled Courses</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active2" href="student_review.php"><i class="fa-solid fa-star me-2"></i> Reviews</a>
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
              <h4 class="m-0">Reviews</h4>
              <div class="py-3">
                <div class="card my-3">
                  <div class="card-header p-3 fs-5 fw-bold">Course: Latex</div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div class="rating">
                        <div class="star-rating mb-3">
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa-regular fa-star rating-color"></i>
                        </div>
                        <div class="review">Awesome!!</div>
                      </div>
                      <div class="edit-rating d-flex">
                        <button class="btn"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                        <button class="btn"><i class="fa-solid fa-trash-can"></i> Delete</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card my-3">
                  <div class="card-header p-3 fs-5 fw-bold">Course: Latex</div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div class="rating">
                        <div class="star-rating mb-3">
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa-regular fa-star rating-color"></i>
                        </div>
                        <div class="review">Awesome!!</div>
                      </div>
                      <div class="edit-rating d-flex">
                        <button class="btn"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                        <button class="btn"><i class="fa-solid fa-trash-can"></i> Delete</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card my-3">
                  <div class="card-header p-3 fs-5 fw-bold">Course: Latex</div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div class="rating">
                        <div class="star-rating mb-3">
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa-regular fa-star rating-color"></i>
                        </div>
                        <div class="review">Awesome!!</div>
                      </div>
                      <div class="edit-rating d-flex">
                        <button class="btn"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                        <button class="btn"><i class="fa-solid fa-trash-can"></i> Delete</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card my-3">
                  <div class="card-header p-3 fs-5 fw-bold">Course: Latex</div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div class="rating">
                        <div class="star-rating mb-3">
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa-regular fa-star rating-color"></i>
                        </div>
                        <div class="review">Awesome!!</div>
                      </div>
                      <div class="edit-rating d-flex">
                        <button class="btn"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                        <button class="btn"><i class="fa-solid fa-trash-can"></i> Delete</button>
                      </div>
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

    <script>

$(document).ready(function(){


});

</script>
</body>

</html>