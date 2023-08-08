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
  a.active {
    border-bottom: 2px solid #007bff;
  }
  .custom_style {
    width: 40%;
  }
  .type_container {
    width: 35%;
  }
</style>

<body>
    <!-- banner section -->
    <div class="container container-banner p-4" style="background-color: rgb(177, 190, 188);">
        <div class="row">
            <div class="col-md-1">
                <img src="img/1.jpg" alt="" height="65" width="65">
            </div>
            <div class="col-md-9 py-2 px-2 ml-auto">
                <h1>BE RESEARCHER BD</h1>
            </div>
            <div class="col-md-2 ml-auto">
                <a href="#"> <i class="fab fa-facebook"></i> </a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"> <i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </div>

    <!-- navbar section -->
    <div class="container-navbar style="background-color: rgb(177, 190, 188);">
        <div class="container">
          <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav m-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="index.php">HOME</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="about.php">ABOUT</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="courses.php">COURSES</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="instructor.php">INSTRUCTORS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="blog.php">BLOG</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="contact.php">CONTACT</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="login.php">LOGIN</a>
                  </li>
                  <li class="nav-item" style="display: <?php echo $display; ?>;">
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
                      <div class="user_photo me-2"><img src="<?php echo $user_photo; ?>" class="img-fluid rounded-circle" width="30px" height="30px"></div>
                      <div class="user_name" style="line-height: 16px;"><span class="text-secondary" style="font-size: 12px;">Hello</span><br><span id="user_name"><?php echo $username; ?></span></div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </div>
    </div>
    
    <div class="container">
        <div class="text-center my-5">
            <h1>Register As</h1>
        </div>
        <div class="type_container m-auto mb-5">
          <div class="row row-cols-1 row-cols-md-2 g-5">
            <div class="col-md-6">
              <a href="register.php" class="text-decoration-none">
                <div class="card">
                  <div class="card-body">
                    <img src="img/student.png" class="img-fluid">
                  </div>
                  <div class="card-footer p-2 text-center"><h4>Student</h4></div>
                </div>
              </a>
            </div>
            <div class="col-md-6">
              <a href="register.php" class="text-decoration-none">
                <div class="card">
                  <div class="card-body">
                    <img src="img/instructor.png" class="img-fluid">
                  </div>
                  <div class="card-footer p-2 text-center"><h4>Instructor</h4></div>
                </div>
              </a>
            </div>
          </div>
        </div>
    </div>

   
    
    

    <!-- Footer Section -->
    <div class="container" style="background-color:rgb(177, 190, 188)">
        <div class="footer">
            <div class="container" id="Contact">
                <div class="row py-5">
                    <div class="col-md-4 text-white">
                        <h4>Publications of Students</h4>
                        <a href="#">ABC</a><br>
                        <a href="#">BCD</a><br>
                        <a href="#">CEF</a><br>
                        <a href="#">REF</a> <br>
                        <a href="#">BJK</a> <br>
                        <a href="#">MOD</a> <br>
                    </div>
                    <div class="col-md-4 text-white">
                        <h4>Publications of Teachers</h4>
                        <a href="#">DUT</a> <br>
                        <a href="#">JNK</a><br>
                        <a href="#">FSK</a><br>
                        <a href="#">ASK</a><br>
                        <a href="#">PSK</a>
                    </div>
                    <div class="col-md-4 text-white">
                        <h4>Important Link:</h4>
                        <a href="https://moedu.gov.bd/">Ministry of Education</a> <br>
                        <a href="https://www.dhakaeducationboard.gov.bd/">Dhaka Education Board</a> <br>
                        <a href="http://www.dshe.gov.bd/">Department of Secondary & Higher Education</a>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-7 text-white">
                        <h3>Connect with Us:</h3>
                        <div class="circle1">

                            <i class="fab fa-facebook-f"></i>

                        </div>
                        <div class="circle1">

                            <i class="fab fa-youtube"></i>

                        </div>
                        <div class="circle1">

                            <i class="fab fa-twitter"></i>

                        </div>
                        <div class="circle1">

                            <i class="fab fa-instagram-square"></i>

                        </div>
                        <div class="circle1">

                            <i class="fas fa-envelope-square"></i>

                        </div>
                        <div class="circle1">

                            <i class="fas fa-mobile-alt"></i>

                        </div>


                    </div>
                    <div class="col-md-5 text-white"> 
                         <h4>Download Our Android App</h4>
                      <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" 
                            width="45%" class="img-fluid" alt="">

                     </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="row">
                    <div class="col text-center text-white">
                        <p>Copyright &copy; 2023 All Rights Reserved by Md Alam Miah, Md Imtiaj, Himel Chakma</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>