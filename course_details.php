<?php
include('admin/main.php');
$object = new brbd();
$got_course_id = '';
if(isset($_GET["course_id"])) 
{
    $got_course_id = $_GET["course_id"];
    $_SESSION["course_id"] = $got_course_id;
}
else
{
    $got_course_id = $_SESSION["course_id"];
}
$display = 'none';
$user_id = '';
if(isset($_SESSION["user_id2"]))
{
  $display = 'block';
  $user_id = $_SESSION["user_id2"];
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
    <link rel="stylesheet" href="css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <title>BRBD</title>
</head>

<style>
   @font-face {
		font-family: myfont;
		src: url(SolaimanLipi.ttf);
	}
  #video_c {
    position: relative;
  }
  .spinner {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 300px;
    z-index: 10;
  }
    iframe {
        width: 100%;
        height: 450px;
    }
    #featured_photo img {
      width: 100%;
      height: 450px;
    }
</style>

<body>
    <?php
      include('navbar.php');
    ?>

    <div class="container m-auto">
        <div class="row">
          <div class="col-md-12">
            <div class="rating_container d-flex">
              <div class="rating me-2">
                <i class="fa fa-star rating-color"></i>
                <i class="fa fa-star rating-color"></i>
                <i class="fa fa-star rating-color"></i>
                <i class="fa fa-star rating-color"></i>
                <i class="fa-regular fa-star rating-color"></i>
              </div>
              <div class="rating_value">3.77 <span class="text-secondary">(18 Ratings)</span></div>
            </div>
            <h2 class="course_title fw-bolder my-3" id="course_title">Course Title</h2>
            <div class="category_container">
              <span class="text-secondary">Categories: </span><span id="course_category"></span>
            </div>
          </div>
        </div>

        <div class="row my-3">
          <div class="col-md-8 pe-3">
            <div class="course_img" id="featured_photo">
              
            </div>
            <div class="course_details my-5">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Course Info</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Reviews</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Announcement</button>
                </li>
              </ul>
              <div class="tab-content p-3" id="myTabContent">
                <div class="tab-pane show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                  <h5 class="course_info_title fw-bolder">About Course</h5>
                  <div class="mb-5" id="course_info"></div>
                    <div class="learning">
                      <div class="row">
                        <h5 class="fw-bolder">What will you learn:</h5>
                        <div class="col-md-6" id="course_learning">
                          <ul>
                            <li>Learning 1</li>
                            <li>Learning 1</li>
                            <li>Learning 1</li>
                            <li>Learning 1</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="course_materials">
                      <h5 class="fw-bolder my-3">Course Materials</h5>
                      <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                              Topic 1
                            </button>
                          </h2>
                          <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                              <ul class="nav flex-column">
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-brands fa-youtube me-2"></i> Lesson 1</div>
                                  <div class="lesson_duration">10:30 <i class="fa-solid fa-lock-open ms-2"></i></div>
                                </li>
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-brands fa-youtube me-2"></i> Lesson 2</div>
                                  <div class="lesson_duration">10:30 <i class="fa-solid fa-lock ms-2"></i></div>
                                </li>
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-brands fa-youtube me-2"></i> Lesson 3</div>
                                  <div class="lesson_duration">10:30 <i class="fa-solid fa-lock ms-2"></i></div>
                                </li>
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-solid fa-file-powerpoint me-2"></i> Power Point Slide</div>
                                </li>
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-regular fa-circle-question me-2"></i> Quiz 1</div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                              Topic 2
                            </button>
                          </h2>
                          <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                            <div class="accordion-body">
                              <ul class="nav flex-column">
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-brands fa-youtube me-2"></i> Lesson 1</div>
                                  <div class="lesson_duration">10:30 <i class="fa-solid fa-lock-open"></i></div>
                                </li>
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-brands fa-youtube me-2"></i> Lesson 2</div>
                                  <div class="lesson_duration">10:30 <i class="fa-solid fa-lock ms-2"></i></div>
                                </li>
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-brands fa-youtube me-2"></i> Lesson 3</div>
                                  <div class="lesson_duration">10:30 <i class="fa-solid fa-lock ms-2"></i></div>
                                </li>
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-solid fa-file-powerpoint me-2"></i> Power Point Slide</div>
                                </li>
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-regular fa-circle-question me-2"></i> Quiz 1</div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                              Topic 3
                            </button>
                          </h2>
                          <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                            <div class="accordion-body">
                              <ul class="nav flex-column">
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-brands fa-youtube me-2"></i> Lesson 1</div>
                                  <div class="lesson_duration">10:30 <i class="fa-solid fa-lock ms-2"></i></div>
                                </li>
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-brands fa-youtube me-2"></i> Lesson 2</div>
                                  <div class="lesson_duration">10:30 <i class="fa-solid fa-lock ms-2"></i></div>
                                </li>
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-brands fa-youtube me-2"></i> Lesson 3</div>
                                  <div class="lesson_duration">10:30 <i class="fa-solid fa-lock ms-2"></i></div>
                                </li>
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-solid fa-file-powerpoint me-2"></i> Power Point Slide</div>
                                </li>
                                <li class="nav-item d-flex justify-content-between border-bottom py-2">
                                  <div class="lesson_title"><i class="fa-regular fa-circle-question me-2"></i> Quiz 1</div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="tab-pane" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                  <h4 class=" fw-bolder">Students Ratings & Reviews</h4>
                  <ul class="list-group my-4">
                    <li class="list-group-item">
                      <div class="row py-4">
                        <div class="col-md-3 text-center">
                          <div class="rating_value_lg fw-bolder" style="font-size: 72px;">3.6</div>
                          <div class="ratings">
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa-regular fa-star rating-color"></i>
                          </div>
                          <div class="total_rating fs-5">Total 10 Ratings</div>
                        </div>
                        <div class="col-md-9">
                          <ul class="nav flex-column">
                            <li class="nav-item d-flex align-items-center">
                              <div class="rating_bullets">
                                <i class="fa-regular fa-star rating-color me-3"></i> 5
                              </div>
                              <div class="progress_container2 ms-3" style="width: 80%;">
                                <div class="progress" style="height: 8px;">
                                  <div class="progress-bar bg-warning" role="progressbar" aria-label="Basic example" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </li>
                            <li class="nav-item d-flex align-items-center">
                              <div class="rating_bullets">
                                <i class="fa-regular fa-star rating-color me-3"></i> 4
                              </div>
                              <div class="progress_container2 ms-3" style="width: 80%;">
                                <div class="progress" style="height: 8px;">
                                  <div class="progress-bar bg-warning" role="progressbar" aria-label="Basic example" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </li>
                            <li class="nav-item d-flex align-items-center">
                              <div class="rating_bullets">
                                <i class="fa-regular fa-star rating-color me-3"></i> 3
                              </div>
                              <div class="progress_container2 ms-3" style="width: 80%;">
                                <div class="progress" style="height: 8px;">
                                  <div class="progress-bar bg-warning" role="progressbar" aria-label="Basic example" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </li>
                            <li class="nav-item d-flex align-items-center">
                              <div class="rating_bullets">
                                <i class="fa-regular fa-star rating-color me-3"></i> 2
                              </div>
                              <div class="progress_container2 ms-3" style="width: 80%;">
                                <div class="progress" style="height: 8px;">
                                  <div class="progress-bar bg-warning" role="progressbar" aria-label="Basic example" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </li>
                            <li class="nav-item d-flex align-items-center">
                              <div class="rating_bullets">
                                <i class="fa-regular fa-star rating-color me-3"></i> 1
                              </div>
                              <div class="progress_container2 ms-3" style="width: 80%;">
                                <div class="progress" style="height: 8px;">
                                  <div class="progress-bar bg-warning" role="progressbar" aria-label="Basic example" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="row p-4">
                        <div class="col-md-3">
                          <div class="course_author">
                            <img src="img/11.jpg" class="img-fluid img-thumbnail rounded-circle me-3" style="width: 50px; height: 50px; border: none;">
                            <h6 class="my-3">Student Name</h6>
                            <p>1 minute ago</p>
                          </div>
                        </div>
                        <div class="col-md-9">
                          <div class="ratings">
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa-regular fa-star rating-color"></i>
                          </div>
                          <div class="review my-3">
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatibus, tenetur? Iure omnis deleniti facere unde amet quam repellat quisquam quo?</p>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="row p-4">
                        <div class="col-md-3">
                          <div class="course_author">
                            <img src="img/11.jpg" class="img-fluid img-thumbnail rounded-circle me-3" style="width: 50px; height: 50px; border: none;">
                            <h6 class="my-3">Student Name</h6>
                            <p>1 minute ago</p>
                          </div>
                        </div>
                        <div class="col-md-9">
                          <div class="ratings">
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa-regular fa-star rating-color"></i>
                          </div>
                          <div class="review my-3">
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatibus, tenetur? Iure omnis deleniti facere unde amet quam repellat quisquam quo?</p>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa-regular fa-star me-2 text-white"></i>Write a review
                  </button>
                  <div class="collapse" id="collapseExample">
                    <div class="rating">
                      <i class="fa fa-star rating-color"></i>
                      <i class="fa fa-star rating-color"></i>
                      <i class="fa fa-star rating-color"></i>
                      <i class="fa fa-star rating-color"></i>
                      <i class="fa-regular fa-star rating-color"></i>
                    </div>
                    <form method="POST">
                      <textarea name="review" id="review" rows="5" class="form-control my-3"></textarea>
                      <input type="submit" class="btn btn-primary" value="Submit Review">
                    </form>
                  </div>
                </div>
                <div class="tab-pane" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                  
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card mb-4">
              <div class="card-header p-4">
                <div class="course_enrollment" id="course_enrollment">
                <?php
                  $object->query = "SELECT * FROM course_enrolled WHERE student_id = '$user_id' AND course_id = '$got_course_id'";

                  $object->execute();

                  $total_row = $object->row_count();

                  $result= $object->get_result();

                  $enrolled_date = '';

                  $enrolled_id = '';

                  foreach($result as $row)
                  {
                      $enrolled_date = $row["enrolled_date"];
                      $date = new DateTime($enrolled_date);
                      $enrolled_date = $date->format('d F Y');
                      $enrolled_id = $row["enrolled_id"];
                  }

                  $object->query = "SELECT * FROM topics WHERE course_id = '$got_course_id'";

                  $object->execute();

                  $total_row2 = $object->row_count();

                  if($total_row > 0)
                  {
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

                      $complete_course = '';

                      if($percent_completed == 100)
                      {
                          $complete_course = '<a href="certificate.php" class="btn btn-success mb-4 form-control"><i class="fa-solid fa-medal me-2"></i> See Certificate</a>';
                      }
                      
                      echo '
                      <h5 class="fw-bolder">Course Progress</h5>
                      <div class="progress_container">
                        <div class="progress_count my-3 d-flex justify-content-between">
                          <div>'.$topic_unlocked.'/'.$total_row2.'</div>
                          <div>'.$percent_completed.'% Complete</div>
                        </div>
                        <div class="progress" style="height: 6px;">
                          <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: '.$percent_completed.'%" aria-valuenow="'.$percent_completed.'" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <a href="course_lessons.php?course_id='.$got_course_id.'" class="btn btn-primary my-4 form-control">Start Leaning</a>
                      '.$complete_course.'
                      <div class="course_enrolled_date">
                        <i class="fa-solid fa-cart-arrow-down text-success"></i> You Enrolled this course on <span class="fw-bolder text-success">'.$enrolled_date.'</span>
                      </div>
                      ';
                  }
                  else
                  {
                      echo '
                      <h5 class="fw-bolder">Free</h5>
                      <button type="button" id="enroll_course" data-user-id = "'.$user_id.'" data-course-id = "'.$got_course_id.'" class="btn btn-primary my-4 form-control">Enroll Course</button>
                      <div class="p-2 text-center text-secondary">Free Access to this course</div>
                      ';
                  }
                ?>
                </div>
              </div>
              <div class="card-body p-4">
                <ul class="nav flex-column">
                  <li class="nav-item py-2">
                    <i class="fa-solid fa-signal me-2"></i> <span id="course_level"></span>
                  </li>
                  <li class="nav-item py-2">
                    <i class="fa-solid fa-graduation-cap me-2"></i> 91 Total Enrolled
                  </li>
                  <li class="nav-item py-2">
                    <i class="fa-regular fa-clock me-2"></i> <span id="course_duration"></span> Duration
                  </li>
                  <li class="nav-item py-2">
                    <i class="fa-solid fa-rotate me-2"></i> June 30, 2023 Last Updated
                  </li>
                </ul>
              </div>
            </div>
            <div class="card">
              <div class="card-header p-4">
                <h6>A course by</h6>
                <div class="course_author d-flex align-items-center">
                  <img src="img/11.jpg" id="course_author_img" class="img-fluid img-thumbnail rounded-circle me-3" style="width: 50px; height: 50px; border: none;">
                  <span class="fw-bolder" id="course_author">Author Name</span>
                </div>
              </div>
              <div class="card-body p-4">
                <h5 class="fw-bolder">Material Includes</h5>
                <ul class="m-0" id="course_materials">
                  <li class="py-2">Material 1</li>
                  <li class="py-2">Material 1</li>
                  <li class="py-2">Material 1</li>
                  <li class="py-2">Material 1</li>
                  <li class="py-2">Material 1</li>
                  <li class="py-2">Material 1</li>
                  <li class="py-2">Material 1</li>
                </ul>
                <h5 class="fw-bolder mt-3">Requirements</h5>
                <ul class="m-0" id="course_requirements">
                  <li class="py-2">Requirements 1</li>
                  <li class="py-2">Requirements 1</li>
                  <li class="py-2">Requirements 1</li>
                  <li class="py-2">Requirements 1</li>
                  <li class="py-2">Requirements 1</li>
                  <li class="py-2">Requirements 1</li>
                  <li class="py-2">Requirements 1</li>
                </ul>
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

        $.ajax({
        
            url:"course_details_action.php",
            
            method:"POST",
            
            data:{course_id: <?php echo $got_course_id; ?>, action:'fetch_course'},
            
            dataType:'JSON',
            
            success:function(data)
            {
                $('#course_title').html(data.course_title);
                $('#course_category').html(data.course_category);
                $('#featured_photo').html(data.featured_photo);
                $('#spinner-c').show();
                $('#spinner-c').css('height','450px');
                $('#spinner').show();
                var youtubeIframe = $('#video_container').find('iframe');
                youtubeIframe.on('load', function() {
                    $('#spinner').hide();
                    $('#spinner-c').hide();
                    $('#spinner-c').css('height','0px'); 
                });
                $('#course_info').html(data.course_info);
                $('#course_level').html(data.course_level);
                $('#course_duration').html(data.course_duration);
                $('#course_author_img').attr('src',data.instructor_photo);
                $('#course_author').html(data.instructor_name);
                $('#course_materials').html(data.course_materials);
                $('#course_requirements').html(data.course_requirements);
                $('#course_learning').html(data.course_learning);
                $('#accordionPanelsStayOpenExample').html(data.course_material_details);
            }
        })

        $(document).on('click', '#enroll_course', function() {

            var course_id = $(this).data('course-id');

            var user_id = $(this).data('user-id');

            if(user_id != '')
            {
              $.ajax({

                  url:"course_details_action.php",
              
                  method:"POST",
              
                  data:{course_id: course_id, action:'enroll_course'},
              
                  dataType:'JSON',

                  beforeSend:function()
	  		    	    {
	  		    	    	  $('#enroll_course').html('<i class="fa-solid fa-circle-notch fa-spin me-2"></i>Enrolling Course');
	  		    	    },
                
                  success:function(data)
                  {
                      $('#course_enrollment').html(data);
                  }
              })
            }
            else
            {
                window.location.href = "login.php";
            }
        });
    });
</script>


</body>
</html>