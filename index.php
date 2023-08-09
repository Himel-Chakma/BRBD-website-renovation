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
    border-radius: 6px;
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
      height: 300px;
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
  @media only screen and (max-width: 767px) {
    .custom-media {
      display: block !important;
    }
  }
</style>

<body>
		<?php
      include('navbar.php');
    ?>
    
    <!-- scroll news -->
    <div class="container">
        <div class="scroll">
            <div class="row py-2">
                <div class="col-md-1  text-center">
                    <h4>News</h4>
                </div>
                <div class="col-md-11 text-align">
                    <marquee direction="left" height="30px">
                        <h5>This is a sample scrolling text that has scrolls texts to left.</h5>
                    </marquee>
                </div>
            </div>
        </div>
    </div>

   

    <div class="container-main">
        <div class="container">
            <div class="row">
                <div class="col-md-7" >
                  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="img/1.jpg" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="img/2.jpg" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="img/3.jpg" class="d-block w-100" alt="...">
                      </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
    
                </div>
                <div class="col">
                  <div class="row">
                    <h6 style="background-color: rgb(17, 2, 95);" class="text-center text-white py-2" >ABOUT</h6>
                    <div class="card">
                      <div class="card-body">
                        <p class="card-text" id="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet urna eleifend, scelerisque justo vitae, fermentum urna. Aliquam erat volutpat. Fusce eleifend consectetur pharetra. </p>
                        <a href="another-page.html" class="card-link">Show More</a>
                      </div>
                    </div>                        
                  </div>
                  <div class="row">
                    <h6 style="background-color: rgb(17, 2, 95);" class="text-center text-white py-2" >Latest Blog</h6>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Special title treatment</h5>
                          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                          <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Special title treatment</h5>
                          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                          <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- course section -->
    <div class="container m-auto py-5">
        <div class="row">
            <div class="col text-center"><h1>ALL COURSES</h1></div>
        </div>
        <div class="row py-3">
          <?php
            $object->query = "SELECT courses.*, instructors.* FROM courses INNER JOIN instructors ON courses.course_author = instructors.instructor_id WHERE course_status != 'Draft'";

            $result = $object->get_result();

            foreach($result as $row)
            {
                $object->query = "SELECT * FROM course_enrolled WHERE course_id = '".$row["course_id"]."'";

                $object->execute();

                $total_enrolled = $object->row_count();

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
                  $enroll = 
                  '<div class="d-flex justify-content-between">
                    <div class="course_price fs-5 fw-bold">$'.$row["course_price"].'</div>
                    <button class="btn btn-outline-primary" id="addcart" data-course-id="'.$row["course_id"].'" data-user-id="'.$user_id.'">Add to Cart</button>
                  </div>';
                }
                
                echo '
                    <div class="col-md-3 p-3">
                        <div class="card course shadow" data-course-id = "'.$row["course_id"].'" style="height: 420px">
                            <a href="course_details.php?course_id='.$row["course_id"].'"><img class="card-img-top border-bottom" src="admin/'.$row["course_photo"].'" alt="Card image cap"></a>
                            <div class="card-img-overlay" style="height: 50px;">
                              <span class="badge" style="background-color: #ff0066;">'.$row["course_level"].'</span>
                            </div>
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
                              <h6 class="card-title py-2 pb-4"><a href="course_details.php?course_id='.$row["course_id"].'" class="text-decoration-none text-reset fw-bold">'.$row["course_title"].'</a></h6>
                              <p class="card-text"><i class="fa-regular fa-user"></i> '.$total_enrolled.' Students <i class="fa-regular fa-clock ms-3"></i> '.$hour.':'.$min.'h</p>
                              
                                <div class="d-flex align-items-center">
                                    <div class="instructor_photo_container">
                                      <img src="'.$row["instructor_photo"].'" class="rounded-circle custom-thumbnail">
                                    </div>
                                    <div class="instructor_category" style="font-size: 12px;">
                                      By <i>'.$row["instructor_name"].'</i> in <i>'.$categories.'</i>
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
          ?>
        </div>
        <div class="row">
          <div class="col d-flex justify-content-center">
            <buttun class="btn btn-primary btn-lg">Browse All Courses</buttun>
          </div>
        </div>
    </div>

    <!-- counter -->
    <div class="container parallax p-0" style="border-radius: 6px;">
      <div class="row m-0 p-0 overlayer">
          <div class="col-md-3 d-flex justify-content-center align-items-center flex-column text-white p-5" style="height: 300px;">
              <h1 style="font-size: 50px;"><span class="counter">500</span>+</h1>
              <h4>Students</h4>
          </div>
          <div class="col-md-3 d-flex justify-content-center align-items-center flex-column text-white p-5" style="height: 300px;">
              <h1 style="font-size: 50px;"><span class="counter">10</span>+</h1>
              <h4>Courses</h4>
          </div>
          <div class="col-md-3 d-flex justify-content-center align-items-center flex-column text-white p-5" style="height: 300px;">
              <h1 style="font-size: 50px;"><span class="counter">65</span>K+</h1>
              <h4>Subscribers</h4>
          </div>
          <div class="col-md-3 d-flex justify-content-center align-items-center flex-column text-white p-5" style="height: 300px;">
              <h1 style="font-size: 50px;"><span class="counter">60</span>K+</h1>
              <h4>Followers</h4>
          </div>
      </div>
    </div>
    <br>
    <br>

    <!-- Review Section -->
    <div class="container p-0 pt-4" style="background-color: #ededed; border-radius: 6px;">
      <h1 style="font-size: 40px;" class="text-center">Elders Review</h1>
      <p class="fs-5 text-center">This reviews make our platform inspiration to serve the students to<br>increase their research skill.</p>
      <div class="reviews position-relative overflow-hidden">
        <button class="navig right" id="right"><i class="fa-solid fa-chevron-right"></i></button>
        <button class="navig left" id="left"><i class="fa-solid fa-chevron-left"></i></button>
        <div class="mover">
            <div class="body" id="body">
                <div class="card shadow border-0 me-3" style="width: 400px; height: 250px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                          <div class="elder-img me-3"><img src="img/101.jpg" class="img-thumbnail rounded-circle" width="60"></div>
                          <div class="details">
                            <div class="fw-bold">Himel Chakma</div>
                            <div>Founder at Save A Smile Foundation</div>
                          </div>
                        </div>
                        <p class="my-3">
                          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellat, quis cumque nemo sapiente, dignissimos quo itaque aspernatur sed saepe.
                        </p>
                        <div class="rating my-3">
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa-regular fa-star rating-color"></i>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 me-3" style="width: 400px; height: 250px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                          <div class="elder-img me-3"><img src="img/101.jpg" class="img-thumbnail rounded-circle" width="60"></div>
                          <div class="details">
                            <div class="fw-bold">Himel Chakma</div>
                            <div>Founder at Save A Smile Foundation</div>
                          </div>
                        </div>
                        <p class="my-3">
                          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellat, quis cumque nemo sapiente, dignissimos quo itaque aspernatur sed saepe.
                        </p>
                        <div class="rating my-3">
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa-regular fa-star rating-color"></i>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 me-3" style="width: 400px; height: 250px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                          <div class="elder-img me-3"><img src="img/101.jpg" class="img-thumbnail rounded-circle" width="60"></div>
                          <div class="details">
                            <div class="fw-bold">Himel Chakma</div>
                            <div>Founder at Save A Smile Foundation</div>
                          </div>
                        </div>
                        <p class="my-3">
                          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellat, quis cumque nemo sapiente, dignissimos quo itaque aspernatur sed saepe.
                        </p>
                        <div class="rating my-3">
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa-regular fa-star rating-color"></i>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 me-3" style="width: 400px; height: 250px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                          <div class="elder-img me-3"><img src="img/101.jpg" class="img-thumbnail rounded-circle" width="60"></div>
                          <div class="details">
                            <div class="fw-bold">Himel Chakma</div>
                            <div>Founder at Save A Smile Foundation</div>
                          </div>
                        </div>
                        <p class="my-3">
                          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellat, quis cumque nemo sapiente, dignissimos quo itaque aspernatur sed saepe.
                        </p>
                        <div class="rating my-3">
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa-regular fa-star rating-color"></i>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 me-3" style="width: 400px; height: 250px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                          <div class="elder-img me-3"><img src="img/101.jpg" class="img-thumbnail rounded-circle" width="60"></div>
                          <div class="details">
                            <div class="fw-bold">Himel Chakma</div>
                            <div>Founder at Save A Smile Foundation</div>
                          </div>
                        </div>
                        <p class="my-3">
                          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellat, quis cumque nemo sapiente, dignissimos quo itaque aspernatur sed saepe.
                        </p>
                        <div class="rating my-3">
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa fa-star rating-color"></i>
                          <i class="fa-regular fa-star rating-color"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    <br><br>

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
    $(document).ready(function() {

        $('#home').toggleClass('active');

        $('.counter').counterUp({
          delay: 10,
          time: 1200
        });

        $(document).on('click', '#addcart', function() {
        
          var course_id = $(this).data('course-id');
          
          var user_id = $(this).data('user-id');

          $('#cart_item_count').css('display','block');
          
          if(user_id != '')
          {
            $.ajax({
            
                url:"course_details_action.php",
            
                method:"POST",
            
                data:{course_id: course_id, action:'add_cart'},
            
                dataType:'JSON',

                success:function(data)
                {
                    $('#cart_items').html(data.cart_items);
                    $('#cart_item_count').html(data.total_items);
                    $('#total_price').html('$'+data.total_price);
                }
            })
          }
          else
          {
              window.location.href = "login.php";
          }
        });

        $(document).on('click', '.delete_items', function() {

          var item_id = $(this).data('item-id');

            $.ajax({
            
                url:"course_details_action.php",
            
                method:"POST",
            
                data:{item_id: item_id, action:'delete_items'},
            
                dataType:'JSON',

                success:function(data)
                {
                    $('#cart_items').html(data.cart_items);
                    $('#cart_item_count').html(data.total_items);
                    $('#total_price').html('$'+data.total_price);
                }
            })
        
        });
    });
</script>
<script>
    const body = document.querySelector(".mover");
    arrow = document.querySelectorAll(".navig");
    const fcw = body.querySelector(".card").offsetWidth;

    const handlebtn = () => {
        let scrollVal = Math.round(body.scrollLeft);
        let maxScrollableWidth = body.scrollWidth - body.clientWidth;
        arrow[1].style.opacity = scrollVal > 0 ? "1" : "0";
        arrow[0].style.opacity = maxScrollableWidth > scrollVal ? "1" : "0";
    }

    arrow.forEach(btn => {
        btn.addEventListener("click", () => {
            body.scrollLeft += btn.id === "left" ? -475 : 475;
            setTimeout(() => handlebtn(), 500);
        });
    });


</script>

</body>

</html>