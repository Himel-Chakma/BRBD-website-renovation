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
.profile-img {
  width: 120px;
  height: 120px;
  border-radius: 50%;
}
.profile-img label {
  width: 120px;
  padding: 8px;
  bottom: 0;
  text-align: center;
  position: absolute;
  cursor: pointer;
  background: rgba(0,0,0,0.4);
  color: white;
}
.profile-img label:hover {
  background: rgba(0,0,0,0.5);
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
                      <a class="nav-link active2" href="student_settings.php"><i class="fa-solid fa-gear me-2"></i> Settings</a>
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
              <h4 class="mb-4">Settings</h4>
              <span id="message"></span>
              <div class="tab-container border-bottom">
                <button class="tab-button active" onclick="expandBorder(this, 'tab-1')">Profile</button>
                <button class="tab-button" onclick="expandBorder(this, 'tab-2')">Password</button>
                <button class="tab-button" onclick="expandBorder(this, 'tab-3')">Social Profile</button>
              </div>
              <div id="tab-1" class="tab-content active py-3">
                <form method="post" id="profile_details_form" enctype="multipart/form-data">
                  <div class="profile-img mb-3 position-relative overflow-hidden">
                    <label for="profile_img"><i class="fa-solid fa-camera"></i></label>
                    <input type="file" name="student_photo" id="profile_img" style="display: none">
                    <img src="img/101.jpg" width="120" id="student_photo" class="rounded-circle">
                    <input type="hidden" name="hidden_student_photo" id="hidden_student_photo">
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="" class="form-label">First Name</label>
                        <input type="text" name="student_first_name" id="student_first_name" class="form-control" placeholder="First Name">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="" class="form-label">Last Name</label>
                        <input type="text" name="student_last_name" id="student_last_name" class="form-control" placeholder="Last Name">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="" class="form-label">Username</label>
                        <input type="text" name="student_user_name" id="student_user_name" class="form-control" placeholder="Username">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="" class="form-label">Phone Number</label>
                        <input type="text" name="student_mobile" id="student_mobile" class="form-control" placeholder="Phone Number">
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                      <label for="" class="form-label">Skill/Occupation</label>
                      <input type="text" name="student_skill" id="student_skill" class="form-control" placeholder="Skill/Occupation">
                  </div>
                  <div class="mb-3">
                      <label for="" class="form-label">Bio</label>
                      <textarea name="student_biography" id="student_biography" rows="5" class="form-control"></textarea>
                  </div>
                  <input type="hidden" name="action" value="update_profile">
                  <button type="submit" class="btn btn-primary" id="update_profile">Update Profile</button>
                </form>
              </div>
            
              <div id="tab-2" class="tab-content py-3">
                <form method="post" id="password_form">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">Current Password</label>
                            <input type="text" name="current_password" class="form-control" placeholder="Current Password">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">New Password</label>
                            <input type="text" name="new_password" class="form-control" placeholder="New Password">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">Retype New Password</label>
                            <input type="text" name="retype_password" class="form-control" placeholder="Retype New Password">
                        </div>
                        <input type="hidden" name="action" value="change_password">
                        <button type="submit" id="change_password" class="btn btn-primary">Change Password</button>
                      </div>
                    </div>
                </form>
              </div>
            
              <div id="tab-3" class="tab-content py-3">
                <h5 class="mb-4">Social Profile Links</h5>
                <form method="post" id="social_form">
                  <div class="row py-2">
                    <div class="col-md-3 mb-3 d-flex align-items-center"><i class="fa-brands fa-facebook-f me-2"></i> Facebook</div>
                    <div class="col-md-6 mb-3 fw-bold">
                      <input type="text" class="form-control" placeholder="https://facebook.com/username/">
                    </div>
                  </div>
                  <div class="row py-2">
                    <div class="col-md-3 mb-3 d-flex align-items-center"><i class="fa-brands fa-twitter me-2"></i> Twitter</div>
                    <div class="col-md-6 mb-3 fw-bold">
                      <input type="text" class="form-control" placeholder="https://twitter.com/username/">
                    </div>
                  </div>
                  <div class="row py-2">
                    <div class="col-md-3 mb-3 d-flex align-items-center"><i class="fa-brands fa-linkedin-in me-2"></i> Linkedin</div>
                    <div class="col-md-6 mb-3 fw-bold">
                      <input type="text" class="form-control" placeholder="https://linkedin.com/username/">
                    </div>
                  </div>
                  <div class="row py-2">
                    <div class="col-md-3 mb-3 d-flex align-items-center"><i class="fa-solid fa-earth-americas me-2"></i> Website</div>
                    <div class="col-md-6 mb-3 fw-bold">
                      <input type="text" class="form-control" placeholder="https://domain.com/">
                    </div>
                  </div>
                  <div class="row py-2">
                    <div class="col-md-3 mb-3 d-flex align-items-center"><i class="fa-brands fa-github me-2"></i> Github</div>
                    <div class="col-md-6 mb-3 fw-bold">
                      <input type="text" class="form-control" placeholder="https://github.com/username/">
                    </div>
                  </div>
                  <input type="hidden" name="action" value="update_social">
                  <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
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

      $('#profile_img').change(function() {
        var output = document.getElementById('student_photo');
        output.src=URL.createObjectURL(event.target.files[0]);
      });

      <?php
       $object->query = "SELECT * FROM students WHERE student_id = '$user_id'";

       $result = $object->get_result();

       foreach($result as $row)
       {
         $student_first_name = $row["student_first_name"];
         $student_last_name = $row["student_last_name"];
         $student_user_name = $row["student_user_name"];
         $student_email = $row["student_email"];
         $student_mobile = $row["student_mobile"];
         $student_skill = $row["student_skill"];
         $student_biography = $row["student_biography"];
         $student_photo = $row["student_photo"];
       }
      ?>

      $('#student_first_name').val("<?php echo $student_first_name; ?>");
      $('#student_last_name').val("<?php echo $student_last_name; ?>");
      $('#student_user_name').val("<?php echo $student_user_name; ?>");
      $('#student_mobile').val("<?php echo $student_mobile; ?>");
      $('#student_skill').val("<?php echo $student_skill; ?>");
      $('#student_biography').val("<?php echo $student_biography; ?>");
      $('#student_photo').attr('src', '<?php echo $student_photo; ?>');
      $('#hidden_student_photo').val('<?php echo $student_photo; ?>');

      $('#profile_details_form').on('submit', function(event){
      		event.preventDefault();	
      			$.ajax({
      				url:"profile_action.php",
      				method:"POST",
      				data:new FormData(this),
              dataType:'json',
              contentType:false,
              processData:false,
      				beforeSend:function()
      				{
      					$('#update_profile').attr('disabled', 'disabled');
      					$('#update_profile').html('wait...');
      				},
      				success:function(data)
      				{
      					  $('#update_profile').attr('disabled', false);

                  $('#update_profile').html('Update Profile');
                  
                  $('#student_first_name').val(data.student_first_name);
                  $('#student_last_name').val(data.student_last_name);
                  $('#student_user_name').val(data.student_user_name);
                  $('#student_mobile').val(data.student_mobile);
                  $('#student_skill').val(data.student_skill);
                  $('#student_biography').val(data.student_biography);
                  $('#student_photo').attr('src', data.student_photo);
                  $('#hidden_student_photo').val(data.student_photo);
                  $('#user_image').attr('src',data.student_photo);
                  $('#user_image2').attr('src',data.student_photo);
                
                  $('#message').html(data.message);
                        
      					  setTimeout(function(){
                
      				        $('#message').html('');
                
      				    }, 3000);
      				}
      			})
      });

      $('#password_form').on('submit', function(event){
      		event.preventDefault();	
      			$.ajax({
      				url:"profile_action.php",
      				method:"POST",
      				data:new FormData(this),
              dataType:'json',
              contentType:false,
              processData:false,
      				beforeSend:function()
      				{
      					$('#change_password').attr('disabled', 'disabled');
      					$('#change_password').html('wait...');
      				},
      				success:function(data)
      				{
      					  $('#change_password').attr('disabled', false);

                  $('#change_password').html('Change Password');
                
                  $('#message').html(data);
                        
      					  setTimeout(function(){
                
      				        $('#message').html('');
                
      				    }, 3000);
      				}
      			})
      });

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