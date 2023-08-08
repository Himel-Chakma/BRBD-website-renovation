<a href="#topbar" id="sms" class="text-decoration-none text-white"><i class="fas fa-chevron-up"></i></a>

<div class="container" id="topbar">
  <div class="d-flex justify-content-between p-2" style="color: #4B6093;">
    <div class="following">
      <a href="" class="text-decoration-none text-reset me-2"><i class="fa-brands fa-youtube me-2"></i> 65k Subscriber</a>
      <a href="" class="text-decoration-none text-reset"><i class="fa-brands fa-square-facebook me-2"></i>60k Follower</a>
    </div>
    <div class="links">
      <a href="#" class="text-decoration-none text-reset me-2"><i class="fa-brands fa-facebook-f"></i></a>
      <a href="#" class="text-decoration-none text-reset me-2"><i class="fa-brands fa-linkedin-in"></i></a>
    </div>
  </div>
</div>

<!-- banner section -->
<div class="container container-banner p-4" style="background-color: #4B6093">
    <div class="d-flex align-items-center">
        <img src="img/logo22.png" class="me-4" height="65" width="65">
        <div class="row" style="width: 100%;">
          <div class="col-md-3"><h1 class="text-white web-title" style="font-family: myfont;">গবেষক হতে চাই :</h1></div>
          <div class="col-md-9"><h1 class="text-white web-title" style="font-family: myfont;">BE RESEARCHER BD</h1></div>
        </div>
    </div>
</div>

<!-- navbar section -->
<div class="container-navbar" id="navbar">
    <div class="container border-bottom">
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container d-flex">
          <div class="nav">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav m-auto">
                <li class="nav-item">
                  <a class="nav-link" id="home" href="index.php">HOME</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="about" href="about.php">ABOUT</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="course" href="courses.php">COURSES</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="instructor" href="instructor.php">INSTRUCTORS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="blog" href="blog.php">BLOG</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact" href="contact.php">CONTACT</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="login" href="login.php">LOGIN</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="profile" style="display: <?php echo $display; ?>;">
              <div class="d-flex align-items-center">
                <div class="me-3 fs-4 cart-hover">
                  <i class="fa-solid fa-cart-plus"></i>
                  <div class="card cart">
                    <div class="card-body p-4">
                      <ul class="m-0 p-0">
                        <li class="nav-item d-flex fs-5 mb-4">
                            <img src="img/people-office.jpg" class="img-fluid rounded me-3" width="80" height="80">
                            <div class="course_details_cont" style="width: 80%;">
                              <a href="" class="text-decoration-none">Latex</a><br>
                              $00
                            </div>
                            <button class="btn" type="button"><i class="fas fa-times"></i></button>
                        </li>
                        <li class="nav-item d-flex fs-5 mb-4">
                            <img src="img/people-office.jpg" class="img-fluid rounded me-3" width="80" height="80">
                            <div class="course_details_cont" style="width: 80%;">
                              <a href="" class="text-decoration-none">Latex</a><br>
                              $00
                            </div>
                            <button class="btn" type="button"><i class="fas fa-times"></i></button>
                        </li>
                        <li class="nav-item d-flex fs-5 mb-4">
                            <img src="img/people-office.jpg" class="img-fluid rounded me-3" width="80" height="80">
                            <div class="course_details_cont" style="width: 80%;">
                              <a href="" class="text-decoration-none">Latex</a><br>
                              $00
                            </div>
                            <button class="btn" type="button"><i class="fas fa-times"></i></button>
                        </li>
                        <li class="nav-item d-flex fs-5 mb-4">
                            <img src="img/people-office.jpg" class="img-fluid rounded me-3" width="80" height="80">
                            <div class="course_details_cont" style="width: 80%;">
                              <a href="" class="text-decoration-none">Latex</a><br>
                              $00
                            </div>
                            <button class="btn" type="button"><i class="fas fa-times"></i></button>
                        </li>
                      </ul>
                    </div>
                    <div class="card-footer px-4 py-2">
                        <div class="d-flex justify-content-between">
                          <div class="fs-5">Total</div>
                          <div class="fs-5">$00</div>
                        </div>
                        <div class="row">
                          <div class="col-md-6 p-2">
                            <button class="btn btn-info form-control">View Cart</button>
                          </div>
                          <div class="col-md-6 p-2">
                            <button class="btn btn-success form-control">Check Out</button>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <a href="student_dashboard.php" class="d-flex align-items-center px-2 text-decoration-none text-reset">
                <?php
                  $object->query = "SELECT * FROM students WHERE student_id = '$user_id'";

                  $result = $object->get_result();

                  $user_photo = '';

                  $username = '';

                  foreach($result as $row)
                  {
                    $user_photo = $row["student_photo"];
                    $username = $row["student_user_name"];
                  }
                ?>
                  <div class="user_photo me-2"><img src="<?php echo $user_photo; ?>" class="img-fluid rounded-circle" width="30px" id="user_image" height="30px"></div>
                  <div class="user_name" style="line-height: 16px;"><span class="text-secondary" style="font-size: 12px;">Hello</span><br><span id="user_name"><?php echo $username; ?></span></div>
                </a>
              </div>
          </div>
        </div>
      </nav>
    </div>
</div>