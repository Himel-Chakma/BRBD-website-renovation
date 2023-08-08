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
.tab-container {
  display: flex;
  align-items: flex-start;
}

.tab-button {
  position: relative;
  border: none;
  outline: none;
  background-color: transparent;
  color: #000;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  overflow: hidden;
}

.tab-button::before {
  content: '';
  position: absolute;
  bottom: 0;
  height: 2px;
  width: 0;
  background-color: #007bff;
  transition: width 0.3s ease-in-out;
  left: 50%;
  transform: translateX(-50%);
}

.tab-button.active::before {
  width: 100%;
}

.tab-content {
  display: none;
}

.tab-content.active {
  display: block;
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
                      <a class="nav-link active2" href="student_course_enrolled.php"><i class="fa-solid fa-graduation-cap me-2"></i> Enrolled Courses</a>
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
              <h4 class="mb-4">Enrolled Courses</h4>
              <div class="tab-container border-bottom">
                <button class="tab-button active" onclick="expandBorder(this, 'tab-1')">Enrolled Courses (<?php echo $object->fetch_count($user_id, 'Enrolled'); ?>)</button>
                <button class="tab-button" onclick="expandBorder(this, 'tab-2')">Active Courses (<?php echo $object->fetch_count($user_id, 'Running'); ?>)</button>
                <button class="tab-button" onclick="expandBorder(this, 'tab-3')">Completed Courses (<?php echo $object->fetch_count($user_id, 'Completed'); ?>)</button>
              </div>
              <div id="tab-1" class="tab-content active">
                <div class="row py-3">
                  <?php
                    $object->query = "SELECT * FROM course_enrolled WHERE student_id = '$user_id' AND enrolled_status = 'Enrolled'";

                    $result3 = $object->get_result();

                    foreach($result3 as $row3)
                    {
                      $object->query = "SELECT courses.*, instructors.* FROM courses INNER JOIN instructors ON courses.course_author = instructors.instructor_id WHERE course_status != 'Draft' AND course_id = '".$row3["course_id"]."'";

                      $result = $object->get_result();
  
                      foreach($result as $row)
                      {
                      
                          $hour = '';
                          $min = '';
                      
                          if($row["course_duration"]) {
                              $duration = $row["course_duration"];
                              $hour = floor($duration/60);
                              $min = $duration % 60;
                          }
                        
                          $object->query = "SELECT category.* FROM courses INNER JOIN (category INNER JOIN category_to_courses ON category.category_id = category_to_courses.category_id) ON courses.course_id = category_to_courses.course_id WHERE courses.course_id = '".$row['course_id']."' ORDER BY category.category_name ASC";
                        
                          $result2 = $object->get_result();
                        
                          $category = array();
                        
                          foreach($result2 as $row2) {
                          
                            $category[] = $row2["category_name"];
                          
                          }
                        
                          $categories = $object->clean_output($category);
                        
                          $object->query = "SELECT * FROM course_enrolled WHERE course_id = '".$row["course_id"]."' AND student_id = '$user_id'";
                        
                          $object->execute();

                          $result4 = $object->get_result();

                          $enrolled_id = '';

                          foreach($result4 as $row4)
                          {
                              $enrolled_id = $row4["enrolled_id"];
                          }

                          $object->query = "SELECT * FROM topics WHERE course_id = '".$row["course_id"]."'";

                          $object->execute();

                          $total_row2 = $object->row_count();

                          $object->query = "SELECT * FROM topic_unlock WHERE enrolled_id = '$enrolled_id' AND unlock_status = 'Unlocked'";

                          $object->execute();

                          $topic_unlocked = $object->row_count();

                          $object->query = "SELECT * FROM material_status_table WHERE enrolled_id = '$enrolled_id'";

                          $object->execute();

                          $total_lesson = $object->row_count();

                          $object->query = "SELECT * FROM material_status_table WHERE enrolled_id = '$enrolled_id' AND material_status = 'complete'";

                          $object->execute();

                          $lesson_completed = $object->row_count();

                          $percent_completed = floor(($lesson_completed/$total_lesson)*100);
                        
                          $enroll = '';
                        
                          if($object->row_count() > 0)
                          {
                            $enroll = '<button class="btn btn-primary custom-a enroll">Start Learning</button>';
                          }
                          else
                          {
                            $enroll = '<button class="btn btn-outline-primary custom-a enroll">ENROLL</button>';
                          }
                        
                          echo '
                              <div class="col-md-4">
                                  <div class="card course shadow" data-course-id = "'.$row["course_id"].'" style="height: 380px">
                                      <a href="course_details.php?course_id='.$row["course_id"].'"><img class="card-img-top border-bottom" src="admin/'.$row["course_photo"].'" alt="Card image cap"></a>
                                      <div class="card-body">
                                        <div class="d-flex align-items-center">
                                          <div class="ratings">
                                              <i class="fa fa-star rating-color"></i>
                                              <i class="fa fa-star rating-color"></i>
                                              <i class="fa fa-star rating-color"></i>
                                              <i class="fa fa-star rating-color"></i>
                                              <i class="fa fa-star"></i>
                                          </div>
                                          <h5 class="review-count m-0">12 Reviews</h5>
                                        </div>
                                        <h6 class="card-title py-2 pb-3"><a href="course_details.php?course_id='.$row["course_id"].'" class="text-decoration-none text-reset fw-bold">'.$row["course_title"].'</a></h6>
                                        <div class="progress_container">
                                          <div class="progress_count my-3 d-flex justify-content-between">
                                            <div>'.$topic_unlocked.'/'.$total_row2.'</div>
                                            <div>'.$percent_completed.'% Complete</div>
                                          </div>
                                          <div class="progress" style="height: 6px;">
                                          <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: '.$percent_completed.'%" aria-valuenow="'.$percent_completed.'" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="card-footer">
                                        '.$enroll.'
                                      </div>
                                  </div>
                              </div>
                          ';
                      }
                    }
                  ?>
                </div>
              </div>
            
              <div id="tab-2" class="tab-content">
                <div class="row py-3">
                  <?php
                    $object->query = "SELECT * FROM course_enrolled WHERE student_id = '$user_id' AND enrolled_status = 'Running'";

                    $result3 = $object->get_result();

                    foreach($result3 as $row3)
                    {
                      $object->query = "SELECT courses.*, instructors.* FROM courses INNER JOIN instructors ON courses.course_author = instructors.instructor_id WHERE course_status != 'Draft' AND course_id = '".$row3["course_id"]."'";

                      $result = $object->get_result();
  
                      foreach($result as $row)
                      {
                      
                          $hour = '';
                          $min = '';
                      
                          if($row["course_duration"]) {
                              $duration = $row["course_duration"];
                              $hour = floor($duration/60);
                              $min = $duration % 60;
                          }
                        
                          $object->query = "SELECT category.* FROM courses INNER JOIN (category INNER JOIN category_to_courses ON category.category_id = category_to_courses.category_id) ON courses.course_id = category_to_courses.course_id WHERE courses.course_id = '".$row['course_id']."' ORDER BY category.category_name ASC";
                        
                          $result2 = $object->get_result();
                        
                          $category = array();
                        
                          foreach($result2 as $row2) {
                          
                            $category[] = $row2["category_name"];
                          
                          }
                        
                          $categories = $object->clean_output($category);
                        
                          $object->query = "SELECT * FROM course_enrolled WHERE course_id = '".$row["course_id"]."' AND student_id = '$user_id'";
                        
                          $object->execute();
                        
                          $enroll = '';
                        
                          if($object->row_count() > 0)
                          {
                            $enroll = '<button class="btn btn-primary custom-a enroll">Start Learning</button>';
                          }
                          else
                          {
                            $enroll = '<button class="btn btn-outline-primary custom-a enroll">ENROLL</button>';
                          }
                        
                          echo '
                              <div class="col-md-4">
                                  <div class="card course shadow" data-course-id = "'.$row["course_id"].'" style="height: 380px">
                                      <a href="course_details.php?course_id = '.$row["course_id"].'"><img class="card-img-top border-bottom" src="admin/'.$row["course_photo"].'" alt="Card image cap"></a>
                                      <div class="card-body">
                                        <div class="d-flex align-items-center">
                                          <div class="ratings">
                                              <i class="fa fa-star rating-color"></i>
                                              <i class="fa fa-star rating-color"></i>
                                              <i class="fa fa-star rating-color"></i>
                                              <i class="fa fa-star rating-color"></i>
                                              <i class="fa fa-star"></i>
                                          </div>
                                          <h5 class="review-count m-0">12 Reviews</h5>
                                        </div>
                                        <h6 class="card-title py-2 pb-3"><a href="course_details.php?course_id = '.$row["course_id"].'" class="text-decoration-none text-reset fw-bold">'.$row["course_title"].'</a></h6>
                                        <div class="progress_container">
                                          <div class="progress_count my-3 d-flex justify-content-between">
                                            <div>0/3</div>
                                            <div>0% Complete</div>
                                          </div>
                                          <div class="progress" style="height: 6px;">
                                            <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="card-footer">
                                        '.$enroll.'
                                      </div>
                                  </div>
                              </div>
                          ';
                      }
                    }
                  ?>
                </div>
              </div>
            
              <div id="tab-3" class="tab-content">
                <div class="row py-3">
                  <?php
                    $object->query = "SELECT * FROM course_enrolled WHERE student_id = '$user_id' AND enrolled_status = 'Completed'";

                    $result3 = $object->get_result();

                    foreach($result3 as $row3)
                    {
                      $object->query = "SELECT courses.*, instructors.* FROM courses INNER JOIN instructors ON courses.course_author = instructors.instructor_id WHERE course_status != 'Draft' AND course_id = '".$row3["course_id"]."'";

                      $result = $object->get_result();
  
                      foreach($result as $row)
                      {
                      
                          $hour = '';
                          $min = '';
                      
                          if($row["course_duration"]) {
                              $duration = $row["course_duration"];
                              $hour = floor($duration/60);
                              $min = $duration % 60;
                          }
                        
                          $object->query = "SELECT category.* FROM courses INNER JOIN (category INNER JOIN category_to_courses ON category.category_id = category_to_courses.category_id) ON courses.course_id = category_to_courses.course_id WHERE courses.course_id = '".$row['course_id']."' ORDER BY category.category_name ASC";
                        
                          $result2 = $object->get_result();
                        
                          $category = array();
                        
                          foreach($result2 as $row2) {
                          
                            $category[] = $row2["category_name"];
                          
                          }
                        
                          $categories = $object->clean_output($category);
                        
                          $object->query = "SELECT * FROM course_enrolled WHERE course_id = '".$row["course_id"]."' AND student_id = '$user_id'";
                        
                          $object->execute();
                        
                          $enroll = '';
                        
                          if($object->row_count() > 0)
                          {
                            $enroll = '<button class="btn btn-primary custom-a enroll">Start Learning</button>';
                          }
                          else
                          {
                            $enroll = '<button class="btn btn-outline-primary custom-a enroll">ENROLL</button>';
                          }
                        
                          echo '
                              <div class="col-md-4">
                                  <div class="card course shadow" data-course-id = "'.$row["course_id"].'" style="height: 380px">
                                      <a href="course_details.php?course_id = '.$row["course_id"].'"><img class="card-img-top border-bottom" src="admin/'.$row["course_photo"].'" alt="Card image cap"></a>
                                      <div class="card-body">
                                        <div class="d-flex align-items-center">
                                          <div class="ratings">
                                              <i class="fa fa-star rating-color"></i>
                                              <i class="fa fa-star rating-color"></i>
                                              <i class="fa fa-star rating-color"></i>
                                              <i class="fa fa-star rating-color"></i>
                                              <i class="fa fa-star"></i>
                                          </div>
                                          <h5 class="review-count m-0">12 Reviews</h5>
                                        </div>
                                        <h6 class="card-title py-2 pb-3"><a href="course_details.php?course_id = '.$row["course_id"].'" class="text-decoration-none text-reset fw-bold">'.$row["course_title"].'</a></h6>
                                        <div class="progress_container">
                                          <div class="progress_count my-3 d-flex justify-content-between">
                                            <div>0/3</div>
                                            <div>0% Complete</div>
                                          </div>
                                          <div class="progress" style="height: 6px;">
                                            <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="card-footer">
                                        '.$enroll.'
                                      </div>
                                  </div>
                              </div>
                          ';
                      }
                    }
                  ?>
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
<script>
 function expandBorder(button, tabId) {
  var tabButtons = document.getElementsByClassName('tab-button');
  for (var i = 0; i < tabButtons.length; i++) {
    tabButtons[i].classList.remove('active');
  }
  button.classList.add('active');

  var tabContents = document.getElementsByClassName('tab-content');
  for (var j = 0; j < tabContents.length; j++) {
    tabContents[j].classList.remove('active');
  }
  document.getElementById(tabId).classList.add('active');

  var tabButtonBorders = document.querySelectorAll('.tab-button::before');
  for (var k = 0; k < tabButtonBorders.length; k++) {
    tabButtonBorders[k].style.width = '0';
  }

  button.querySelector('::before').style.width = '100%';
}

</script>
</body>

</html>