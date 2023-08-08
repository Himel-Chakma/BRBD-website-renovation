<?php
include('header.php');
$got_course_id = '';

if(isset($_GET["course_id"])) 
{
    $_SESSION["course_id"] = $_GET["course_id"];
    $got_course_id = $_GET["course_id"];
}
?>
<style>
  .step-indicator, .step-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  .step-indicator {
    padding: 0px 10px;
  }
  .step-heading {
    margin-bottom: 10px;
  }
  .step-indicator .step {
    width: 10px;
    height: 10px;
    background-color: #007bff;
    border-radius: 50%;
  }
  .step-indicator .step:not(:first-child) {
    background-color: #ccc;
  }
  .step-indicator .step.active {
    background-color: #007bff;
  }
  .step-indicator .connector {
    width: 200px;
    height: 2px;
    background-color: #ccc;
    z-index: 10;
  }
  .step-indicator .step:not(:first-child),
  .step-indicator .step.visited {
    z-index: 10;
  }
  #progress-bar {
      width: 0%;
    }
  #featured_video_container iframe {
    width: 100%;
    height: 200px;
  }
  .add_image, .add_video, .add_doc {
    width: 100%;
    height: 50px;
    background-color: #eee;
    cursor: pointer;
  }
  #preview.disabled {
    pointer-events: none;
    cursor: not-allowed;
  }
  #draggable-list {
    list-style-type: none !important;
    padding: 0;
    margin: 0;
  }
  #draggable-list li.list_items {
    cursor: move;
  }
  #certificate_selection {
    position: relative;
  }
  .certificate {
    position: absolute;
    top: 5px;
    left: 5px;
  }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->

<form method="post" id="course_form" enctype="multipart/form-data">
    <div class="row">
      <div class="col">
        <span id="message"></span>
        <div class="card shadow mb-4">
          <div class="card-header py-3">
              <div class="row">
                  <div class="col">
                      <h4 class="m-0 font-weight-bold text-primary" id="course_heading_title">Add Course</h4>
                  </div>
                  <div clas="col" align="right">
                      <button type="button" name="save_course" id="save_course" class="btn btn-warning btn-sm" disabled><i class="fa fa-file" aria-hidden="true"></i> Save</button>
                      &nbsp;&nbsp;
                      <a href="../course_details.php" target="_blank" id="preview" class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Preview</a>&nbsp;&nbsp;
                      <?php
                        $object->query = "SELECT * FROM courses WHERE course_id = '$got_course_id'";

                        $result = $object->get_result();

                        foreach($result as $row)
                        {
                            if($row["course_status"] == 'Draft' && $admin_type == 'master')
                            {
                                echo '<button type="button" id="publish" data-admin-type="'.$admin_type.'" class="btn btn-primary btn-sm" disabled>Publish</button>&nbsp;&nbsp;';
                            }
                            else if($row["course_status"] == 'Draft' && $admin_type == 'instructor')
                            {
                                echo '<button type="button" id="publish" data-admin-type="'.$admin_type.'" class="btn btn-warning btn-sm" disabled>Submit</button>&nbsp;&nbsp;';
                            }
                            else if($row["course_status"] == 'Publish')
                            {
                                echo '<button type="button" id="publish" data-admin-type="'.$admin_type.'" class="btn btn-primary btn-sm" disabled>Published</button>&nbsp;&nbsp;';
                            }
                            else if($row["course_status"] == 'Pending')
                            {
                                echo '<button type="button" id="publish" data-admin-type="'.$admin_type.'" class="btn btn-warning btn-sm" disabled>Pending</button>&nbsp;&nbsp;';
                            }
                        }
                      ?>
                      
                      <button type="button" id="delete_course" class="btn btn-danger btn-sm" disabled><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                  </div>
              </div>
          </div>
          <div class="card-body">
              <div class="row">
                  <div class="col-md-8">
                      <div class="form-group">
                          <label>Course Title</label>
                          <input type="text" name="course_title" id="course_title" class="form-control">
                      </div>
                      <div class="form-group">
                          <label>Course Info</label>
                          <textarea name="course_info" id="course_info" class="form-control"></textarea>
                      </div>
                      <div class="form-group">
                          <label>Author</label>
                          <select name="course_author" id="course_author" class="form-control">
                          <?php
                          $object->query = "SELECT DISTINCT instructors.instructor_name, instructors.instructor_id FROM instructors INNER JOIN courses ON courses.course_author = instructors.instructor_id";

                          $result = $object->get_result();

                          foreach($result as $row) {
                            echo '
                              <option value="'.$row["instructor_id"].'">'.$row["instructor_name"].'</option>
                            ';
                          }
                          ?>
                            <option value="1">Master User (Profile Name)</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label>Course Duration (In minute)</label>
                          <input type="text" name="course_duration" id="course_duration" class="form-control" />
                      </div>
                      <div class="form-group">
                          <label>Difficulty Level</label>
                          <select name="course_level" id="course_level" class="form-control">
                            <option value="">Select Difficulty Level</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Expert">Expert</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label>Course Learning</label>
                          <textarea name="course_learning" id="course_learning" rows="5" class="form-control"></textarea>
                      </div>
                      <div class="card">
                        <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Course Builder</h6></div>
                        <div class="card-body">
                          <div class="form-group" id="topic_container">
                            <ul id="draggable-list">Add Title First to create course materials.</ul>
                          </div>
                          <div class="form-group">
                            <button type="button" class="btn btn-primary btn-sm" id="add_topic" disabled><i class="fas fa-plus mr-2"></i> Add Topic</button>
                          </div>
                        </div>
                      </div>
                      <div class="card mt-3">
                        <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Course Completion Certificate</h6></div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-4">
                              <label for="certificate" id="certificate_selection">
                                <input type="radio" name="course_certificate" value="" class="certificate" id="certificate" checked>
                                <img src="img/none.png" class="img-fluid">
                              </label>
                            </div>
                            <div class="col-md-4">
                              <label for="certificate1" id="certificate_selection">
                                <input type="radio" name="course_certificate" value="img/certificate1.png" class="certificate" id="certificate1">
                                <img src="img/certificate1.png" class="img-fluid">
                              </label>
                            </div>
                            <div class="col-md-4">
                              <label for="certificate2" id="certificate_selection">
                                <input type="radio" name="course_certificate" value="img/certificate2.png" class="certificate" id="certificate2">
                                <img src="img/certificate2.png" class="img-fluid">
                              </label>
                            </div>
                            <div class="col-md-4">
                              <label for="certificate3" id="certificate_selection">
                                <input type="radio" name="course_certificate" value="img/certificate3.png" class="certificate" id="certificate3">
                                <img src="img/certificate3.png" class="img-fluid">
                              </label>
                            </div>
                            <div class="col-md-4">
                              <label for="certificate4" id="certificate_selection">
                                <input type="radio" name="course_certificate" value="img/certificate4.png" class="certificate" id="certificate4">
                                <img src="img/certificate4.png" class="img-fluid">
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="card mb-3">
                        <div class="card-header py-2">
                          <h6 class="m-0 font-weight-bold text-primary">Category</h6>
                        </div>
                        <div class="card-body">
                          <ul class="nav flex-column" id="categoryList">
                              
                          </ul>
                          <span id="category_msg">Add Title First to assign category.</span>
                          <button type="button" id="addCategoryBtn" class="btn btn-outline-primary btn-sm" disabled><i class="fas fa-plus mr-2"></i> Add Category</button>
                          <div id="categoryForm" style="display: none;">
                            <div class="form-group mt-3">
                              <input type="text" class="form-control" id="newCategoryInput" placeholder="Enter category name">
                            </div>
                            <div class="form-group">
                              <select class="form-control" id="existingCategorySelect">
                                <option value="">Select existing category</option>
                                <?php
                                    $object->query = "SELECT * FROM category";
                                    $result = $object->get_result();
                                    foreach($result as $row) {
                                      echo '
                                        <option value="'.$row["category_id"].'">'.$row["category_name"].'</option>
                                      ';
                                    }
                                ?>
                              </select>
                            </div>
                            <button type="button" id="addNewCategoryBtn" class="btn btn-outline-primary btn-sm">Add Category</button>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                          <label>Featured Image</label><br />
                          <label class="d-flex justify-content-center align-items-center rounded add_image" for="user_image"><i class="fa-solid fa-circle-plus mr-2"></i> Upload Image</label>
                          <input type="file" style="display:none;" name="user_image" id="user_image" />
                          <img src="img/3.jpg" id="featured_image" class="img-fluid rounded" alt="">
                      </div>
                      <div class="form-group">
                          <label>Featured Video (Paste Youtube Iframe Code)</label><br />
                          <input type="text" name="featured_video" id="featured_video" class="form-control"/>
                          <div class="mt-2" id="featured_video_container"></div>
                      </div>
                      <div class="form-group">
                          <label>Material Includes (One per line)</label>
                          <textarea name="course_material" id="course_material" rows="5" class="form-control"></textarea>
                      </div>
                      <div class="form-group">
                          <label>Requirements (One per line)</label>
                          <textarea name="course_requirements" id="course_requirements" rows="5" class="form-control"></textarea>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</form>

<!-- Footer -->
<footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

<div id="topicModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="topic_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Data</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
		          		<label>Topic</label>
		          		<input type="text" name="topic" id="topic" class="form-control">
		          	</div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add_topic" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<div id="lessonModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="lesson_form" enctype="multipart/form-data">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Data</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body" style="height: 500px; overflow: auto;">
        			<span id="form_message"></span>
		          	<div class="form-group">
		          		<label>Lesson Name</label>
		          		<input type="text" name="lesson" id="lesson" class="form-control">
		          	</div>
                <div class="form-group">
		          		<label>Lesson Info</label>
		          		<textarea name="lesson_info" id="lesson_info" class="form-control" rows="5"></textarea>
		          	</div>
                <div class="form-group">
                  <label>Lesson Type:</label>
                  <select name="lesson_type" id="lesson_type" class="form-control">
                    <option value="">Select Type</option>
                    <option value="Video Lesson">Video Lesson</option>
                    <option value="Power Point Slide">Power Point Slide/ PDF</option>
                    <option value="YouTube Video">YouTube Video</option>
                  </select>
                </div>
                <div class="form-group" id="doc_file" style="display: none;">
                  <label>Upload File</label>
                  <label class="d-flex justify-content-center align-items-center rounded add_doc" for="doc_file"><i class="fa-solid fa-circle-plus mr-2"></i> Select PDF/doc File</label>
                  <input type="file" style="display: none;" name="doc_file" id="doc_file" class="form-control">
                </div>
                <div class="form-group" id="normal_file" style="display: none;">
                  <label>Upload File</label>
                  <label class="d-flex justify-content-center align-items-center rounded add_video" for="lesson_file"><i class="fa-solid fa-circle-plus mr-2"></i> Select Video File</label>
                  <input type="file" style="display: none;" name="lesson_file" id="lesson_file" class="form-control">
                    <div class="progress mt-2" id="progress" style="display: none;">
                      <div class="progress-bar" id="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  <button type="button" class="btn btn-primary mt-2" id="upload_file">Upload File</button>
                </div>
                <div class="form-group" id="embeded_file" style="display: none;">
                  <label>Paste the Youtube Embed Iframe Link</label>
                  <input type="text" name="youtube_video" id="youtube_video" class="form-control">
                </div>
                <div class="form-group" id="video_container">

                </div>
                <div class="form-group" id="video_duration_count" style="display: none;">
                  <label>Video Duration</label>
                  <div class="row px-2">
                    <div class="col-4 p-2">
                      <div class="form-control" id="hour"></div>
                    </div>
                    <div class="col-4 p-2">
                      <div class="form-control" id="min"></div>
                    </div>
                    <div class="col-4 p-2">
                      <div class="form-control" id="sec"></div>
                    </div>
                  </div>
                  <div class="row px-2">
                    <div class="col-4">Hour</div>
                    <div class="col-4">Minute</div>
                    <div class="col-4">Second</div>
                  </div>
                  <input type="hidden" name="video_duration" id="video_duration">
                </div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id2" id="hidden_id2" />
                <input type="hidden" name="hidden_id3" id="hidden_id3" />
          			<input type="hidden" name="action" id="action2" value="Add_lesson" />
          			<input type="submit" name="submit" id="submit_button2" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<div id="quizModal" class="modal fade">
  	<div class="modal-dialog">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Quiz</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
                <div class="step-heading">
                  <div class="step-title">Quiz Info</div>
                  <div class="step-title">Question</div>
                  <div class="step-title">Setting</div>
                </div>
                <div class="step-indicator">
                  <div class="step active"></div>
                  <div class="connector"></div>
                  <div class="step"></div>
                  <div class="connector"></div>
                  <div class="step"></div>
                </div>

                <!-- Step 1 -->
                <div id="step1">
                  <div class="form-group">
                    <label>Quiz Title <span id="quiz_id"></span></label>
                    <input type="hidden" name="hidden_id4" id="hidden_id4" />
                    <input type="text" name="quiz_title" id="quiz_title" class="form-control">
                  </div>
                  <button type="button" id="primary_quiz_add" class="btn btn-primary next-step">Save & Next</button>
                </div>

                <!-- Step 2 -->
                <div id="step2" style="display: none;">
                  <ul class="nav flex-column mb-3" id="question_container">
                      
                  </ul>
                  <button type="button" class="btn btn-primary btn-sm gotoNestedStep"><i class="fas fa-plus mr-2"></i>Add Question</button>
                  <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-primary previous-step">Previous</button>
                    <button type="button" class="btn btn-primary next-step">Save & Next</button>
                  </div>
                </div>

                <!-- Nested Step -->
                <div id="nestedStep" style="display: none;">
                  <button type="button" class="btn btn-outline-secondary btn-sm gotoStep2 mb-3"><i class="fa-solid fa-arrow-left mr-2"></i>Back</button>
                  <span id="message2"></span>
                  <form id="option_form" method="post">
                  <div class="form-group">
                    <label>Write your question here</label>
                    <input type="text" name="question" id="question" class="form-control">
                  </div>
                  <div class="form-group">
                    <label >Options</label>
                    <ul class="nav flex-column mb-3 px-2" id="option_container">
                        
                    </ul>
                    <button type="button" class="btn btn-outline-primary btn-sm add_option"><i class="fas fa-plus mr-2"></i>Add Option</button>
                  </div>
                  <input type="hidden" name="action4" id="action4">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-2"></i>Add to Questions</button>
                  </form>
                </div>

                <div id="nestedStep2" style="display: none;">
                  <button type="button" class="btn btn-outline-secondary btn-sm gotoNestedStep2 mb-3"><i class="fa-solid fa-arrow-left mr-2"></i>Back</button>
                  <div class="form-group">
                    <label>Option Title</label>
                      <input type="text" name="option_title" id="option_title" class="form-control">
                  </div>
                  <button type="button" class="btn btn-primary btn-sm update_option">Update Options</button>
                </div>

                <!-- Step 3 -->
                <div id="step3" style="display: none;">
                  <div class="form-group">
                    <label>Time Limit</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="number" name="quiz_duration" id="quiz_duration" class="form-control">
                      </div>
                      <div class="col-md-6">
                        <select name="time_unit" id="time_unit" class="form-control">
                          <option value="1">Minute</option>
                          <option value="60">Hour</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Passing Grade (%)</label>
                    <input type="number" name="passing_percentage" id="passing_percentage" class="form-control">
                  </div>
                  <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-primary previous-step">Previous</button>
                    <button type="button" class="btn btn-primary update_quiz" data-dismiss="modal">Save & Next</button>
                  </div>
                </div>
        		</div>
        		<!-- <div class="modal-footer">
          			<input type="hidden" name="hidden_id4" id="hidden_id4" />
          			<input type="hidden" name="action" id="action3" value="Add_quiz" />
                <button type="button" class="btn btn-primary previous-step">Previous</button>
                <button type="button" class="btn btn-primary next-step">Save & Next</button>
        		</div> -->
      		</div>
  	</div>
</div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <script src="vendor/ckeditor/ckeditor.js"></script>

  <script src="https://www.youtube.com/iframe_api"></script>

  <script>
  CKEDITOR.replace('course_info');
  CKEDITOR.replace('lesson_info');
  </script>

  <script src="vendor/jquery/jquery-ui.js"></script>

  <script>
    $(document).ready(function() {

      $("#draggable-list").sortable({
        update: function(event, ui) {

          var sortedIDs = [];

          $("#draggable-list li.list_items").each(function() {
            sortedIDs.push($(this).data("id"));
          });
        
          $.ajax({
            url: "courses_action.php",
            method: "POST",
            data: { sortedIDs: sortedIDs, action: 'update_topic_serial' },
            success: function(data) {
              
            }
          });
        }
      });

      $("#preview").addClass("disabled");

      let initial_insert2 = true;

      var got_course_id = '<?php echo $got_course_id; ?>';

      if(got_course_id == '') 
      {
        $('#course_title').on("change", function(event) {
          event.preventDefault();
          var course_title = $(this).val();
          var course_author = $('#course_author').val();
          var insert_type = 'insert';
          if(initial_insert2) {
            insert_type = 'insert';
            initial_insert2 = false;
          } else {
            insert_type = 'update';
          }
            $.ajax({
              url: "courses_action.php",
              method: "POST",
              data: {action:'primary_add', course_title:course_title, course_author:course_author, insert_type: insert_type},
              dataType:'JSON',
              success:function(data) {
                $('#course_title').val(data.course_title);
                $('#course_author').val(data.course_author);
                $('#add_topic').removeAttr('disabled');
                $("#addCategoryBtn").removeAttr('disabled');
                $("#publish").removeAttr('disabled');
                $("#delete_course").removeAttr('disabled');
                $("#save_course").removeAttr('disabled');
                $("#preview").removeClass("disabled");
                $('#topic_container').html('');
                $('#category_msg').html('');
              }
            }) 
        });
      }
      else
      {
        $.ajax({
          url: "courses_action.php",
          method: "POST",
          data: {action:'fetch_course'},
          dataType:'JSON',
          success:function(data) {
            $('#add_topic').removeAttr('disabled');
            $("#addCategoryBtn").removeAttr('disabled');
            $("#delete_course").removeAttr('disabled');
            $("#save_course").removeAttr('disabled');
            $("#preview").removeClass("disabled");
            $('#course_title').val(data.course_title);
            $('#course_author').val(data.course_author);
            $('#course_info').val(data.course_info);
            $('#course_duration').val(data.course_duration);
            $('#course_level').val(data.course_level);
            $('#course_material').val(data.course_materials2);
            $('#course_learning').val(data.course_learning);
            $('#course_requirements').val(data.course_requirements);
            $('#featured_image').attr('src',data.course_photo);
            $('#featured_video').val(data.featured_video);
            $("input[name=course_certificate][value='"+data.course_certificate+"']").prop("checked", true);
            $('#featured_video_container').html(data.featured_video);
            $('#course_heading_title').html('Edit Course');
            $('#draggable-list').html(data.course_materials);
            $('#categoryList').html(data.course_category);
            $('#category_msg').html('');
          }
        })
      }

      function getYouTubeVideoDuration() {
        var iframeSrc = $('#youtube_video').val();
        var videoId = getYouTubeVideoId(iframeSrc);

        var apiUrl = 'https://www.googleapis.com/youtube/v3/videos';
        var apiKey = 'AIzaSyBxojb4GgDEzJsfepmbPhusEPTzuLo1Xtc'; 

        var requestUrl = apiUrl + '?id=' + videoId + '&key=' + apiKey + '&part=contentDetails';

        $.ajax({
          url: requestUrl,
          method: 'GET',
          dataType: 'json',
          success: function (data) {
            var duration = data.items[0].contentDetails.duration;
            var durationInSeconds = parseDurationToSeconds(duration);

            var hours = Math.floor(durationInSeconds / 3600);
            var minutes = Math.floor((durationInSeconds % 3600) / 60);
            var seconds = durationInSeconds % 60;

            $('#hour').text(hours);
            $('#min').text(minutes);
            $('#sec').text(seconds);
            $('#video_duration').val(durationInSeconds);
          }
        });
      }

      function getYouTubeVideoId(iframeTag) {
        var regExp = /src=["'](.*?)["']/;
        var match = iframeTag.match(regExp);
        var url = match && match[1] ? match[1] : false;
      
        if (url) {
          var regExpId = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*$/;
          var matchId = url.match(regExpId);
          return matchId && matchId[7] && matchId[7].length === 11 ? matchId[7] : false;
        }
      
        return false;
      }

      function parseDurationToSeconds(duration) {
        var match = duration.match(/PT(\d+H)?(\d+M)?(\d+S)?/);

        var hours = (parseInt(match[1]) || 0);
        var minutes = (parseInt(match[2]) || 0);
        var seconds = (parseInt(match[3]) || 0);

        return hours * 3600 + minutes * 60 + seconds;
      }

      $('#add_topic').click(function(){
      
        $('#topic_form')[0].reset();
      
        $('#modal_title').text('Add Data');
      
        $('#action').val('Add_topic');
      
        $('#submit_button').val('Add');
      
        $('#topicModal').modal('show');
      
      });

      $('#topic_form').on('submit', function(event){
	    	event.preventDefault();	
	    		$.ajax({
	    			url:"courses_action.php",
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
	    				$('#submit_button').attr('disabled', false);
              $('#topicModal').modal('hide');
	    				$('#draggable-list').html(data);
	    			}
	    		})
	    });

      $(document).on('click', '#add_lesson', function() {

          var topic_id = $(this).data('topic-id');

          $('#lesson_form')[0].reset();
        
          $('#modal_title').text('Add Data');
        
          $('#action2').val('Add_lesson');
        
          $('#submit_button2').val('Add');
        
          $('#lessonModal').modal('show');

          $('#hidden_id2').val(topic_id);

          $('#normal_file').hide();

          $('#embeded_file').hide();

          $('#doc_file').hide();

          $('#video_container').hide();

          $('#video_duration_count').hide();

          $('#hour').text('');
          $('#min').text('');
          $('#sec').text('');
          
      });

      $("#lesson_type").change(function(event) {
        var lesson_type = $(this).val();
        if(lesson_type === 'Video Lesson') 
        {
          $('#normal_file').show();
          $('#video_duration_count').show();
          $('#doc_file').hide();
        }
        else if(lesson_type === 'YouTube Video') 
        {
          $('#embeded_file').show();
          $('#normal_file').hide();
          $('#video_duration_count').show();
          $('#doc_file').hide();
          $('#video_container').show();
          $('#video_container').html('');
        }
        else
        {
          $('#doc_file').show();
          $('#normal_file').hide();
          $('#embeded_file').hide();
          $('#video_duration_count').hide();
        }
      });

      $('#lesson_form').on('submit', function(event) {
        var topic_id = $('#hidden_id2').val();
	    	event.preventDefault();	
	    		$.ajax({
	    			url:"courses_action.php",
	    			method:"POST",
	    			data:$(this).serialize(),
            dataType:'json',
	    			beforeSend:function()
	    			{
	    				$('#submit_button2').attr('disabled', 'disabled');
	    				$('#submit_button2').val('wait...');
	    			},
	    			success:function(data)
	    			{
	    				$('#submit_button2').attr('disabled', false);
              $('#lessonModal').modal('hide');
              $('#topic'+topic_id).html(data);
	    			}
	    		})
	    });

      $("#addCategoryBtn").click(function() {
        $("#categoryForm").toggle();
        $(this).toggle();
      });
    
      $("#existingCategorySelect").change(function(event) {
        event.preventDefault();
        var selectedCategory = $(this).val();
        if (selectedCategory !== "") {
          $.ajax({
            url: "courses_action.php",
            method: "POST",
            data: {action:'add_category', category:selectedCategory},
            dataType:'JSON',
            success:function(data) {
              $('#categoryList').html(data);
              $("#existingCategorySelect").val('');
            }
          })
        }
      });

      $(document).on('click', '#addNewCategoryBtn', function(event) {
        event.preventDefault();
        var newCategory = $("#newCategoryInput").val();
        if (newCategory !== "") {
          $.ajax({
            url: "courses_action.php",
            method: "POST",
            data: {action:'add_category', new_category:newCategory},
            dataType:'JSON',
            success:function(data) {
              $('#categoryList').html(data);
              $("#newCategoryInput").val('');
            }
          })
        }
      });

      $(document).on('click', '.delete_category', function() {

        var category_id = $(this).data('category-id');

        if(confirm("Are you sure you want to delete the category?"))
      	{

        		$.ajax({

          		url:"courses_action.php",

          		method:"POST",

          		data:{action:'delete_category', category_id: category_id},

          		success:function(data)
          		{

                $('#categoryList').html(data);

          		}

        		})

      	}
      });

      $(document).on('click', '.edit_topic', function(){
      
        var topic_id = $(this).data('topic-id');
        
        $.ajax({
        
            url:"courses_action.php",
        
            method:"POST",
        
            data:{topic_id:topic_id, action:'fetch_single_topic'},
        
            dataType:'JSON',
        
            success:function(data)
            {
            
              $('#topic').val(data.topic_name);
            
              $('#modal_title').text('Edit Data');
            
              $('#action').val('Edit_topic');
            
              $('#submit_button').val('Edit');
            
              $('#topicModal').modal('show');
            
              $('#hidden_id').val(topic_id);
            
            }
          
        })

      });

      $(document).on('click', '.edit_material', function(){

        var material_id = $(this).data('material-id');

        var topic_id = $(this).data('topic-id');

        $.ajax({
        
            url:"courses_action.php",
        
            method:"POST",
        
            data:{material_id:material_id, action:'fetch_single_material'},
        
            dataType:'JSON',
        
            success:function(data)
            {
            
              $('#lesson').val(data.lesson_name);
              $('#lesson_info').val(data.lesson_info);
              $('#lesson_type').val(data.lesson_type);

              if(data.lesson_type === 'Video Lesson') 
              {
                $('#normal_file').show();
                $('#embeded_file').hide();
                $('#video_duration_count').show();
                $('#doc_file').hide();
                $('#video_container').html('<video width="300" height="180" controls src="'+data.material_link+'"></video>')
              }
              else if(data.lesson_type === 'YouTube Video') 
              {
                $('#embeded_file').show();
                $('#normal_file').hide();
                $('#video_duration_count').show();
                $('#doc_file').hide();
                $('#youtube_video').val(data.material_link);
                $('#video_container').html(data.material_link);
                var iframe = $('#video_container').find('iframe');
                iframe.attr('width', '300');
                iframe.attr('height', '180');
              }
              else
              {
                $('#doc_file').show();
                $('#normal_file').hide();
                $('#embeded_file').hide();
                $('#video_duration_count').hide();
              }
            
              $('#modal_title').text('Edit Data');
            
              $('#action2').val('Edit_material');
            
              $('#submit_button2').val('Edit');
            
              $('#lessonModal').modal('show');
            
              $('#hidden_id3').val(material_id);

              $('#hidden_id2').val(topic_id);

              var hours = Math.floor(data.video_duration / 3600);
              var minutes = Math.floor((data.video_duration % 3600) / 60);
              var seconds = data.video_duration % 60;

              $('#hour').text(hours);
              $('#min').text(minutes);
              $('#sec').text(seconds);
              $('#video_duration').val(data.video_duration);
            
            }
          
        })

      });

      $('#course_form').on('submit', function(event) {
        var topic_id = $('#hidden_id2').val();
	    	event.preventDefault();	
	    		$.ajax({
	    			url:"courses_action.php",
	    			method:"POST",
	    			data:$(this).serialize(),
            dataType:'json',
	    			beforeSend:function()
	    			{
	    				$('#submit_button2').attr('disabled', 'disabled');
	    				$('#submit_button2').val('wait...');
	    			},
	    			success:function(data)
	    			{
	    				$('#submit_button2').attr('disabled', false);
              $('#lessonModal').modal('hide');
              $('#topic'+topic_id).html(data);
	    			}
	    		})
	    });

      let currentStep = 1;

      $('.previous-step').hide();

      $('.next-step').click(function() {
        if (currentStep < 3) {
          $('#step' + currentStep).hide();
          currentStep++;
          $('#step' + currentStep).show();
          updateStepIndicator();
          if(currentStep !== 2) {
            $('#nestedStep').hide();
            $('#nestedStep2').hide();
          }
          if(currentStep !== 1) {
            $('.previous-step').show();
          }
        }
      });

      $('.previous-step').click(function() {
        if (currentStep > 1) {
          $('#step' + currentStep).hide();
          currentStep--;
          $('#step' + currentStep).show();
          updateStepIndicator();
          if(currentStep !== 2) {
            $('#nestedStep').hide();
            $('#nestedStep2').hide();
          }
          if(currentStep === 1) {
            $('.previous-step').hide();
          }
        }
      });

      $('.gotoNestedStep').click(function() {
          $('#step2').hide();
          $('#nestedStep').show();
          currentStep = 2;
          $('#option_container').html('');
          $('#question').val('');
          $('#action4').val('add');
      });

      $('.gotoStep2').click(function() {
          $('#nestedStep').hide();
          $('#step2').show();
      });

      $('.add_option').click(function() {
          $('#nestedStep').hide();
          $('#nestedStep2').show();
          $('#option_title').val('');
          currentStep = 2;
      });

      $('.gotoNestedStep2').click(function() {
          $('#nestedStep2').hide();
          $('#nestedStep').show();
          currentStep = 2;
      });

      function updateStepIndicator() {
        $('.step').each(function(index) {
          if (index + 1 === currentStep) {
            $(this).addClass('active');
          } else if (index + 1 < currentStep) {
            $(this).addClass('visited');
          } else {
            $(this).removeClass('active').removeClass('visited');
          }
        });

        $('.connector').each(function(index) {
          if (index + 1 < currentStep) {
            $(this).css('background-color', '#007bff');
          } else {
            $(this).css('background-color', '#ccc');
          }
        });
      }

      $(document).on('click', '#add_quiz', function() {
      
        var topic_id = $(this).data('topic-id');

        currentStep = 1;

        $('#quiz_title').val('');

        $('#question_container').html('');

        $('#quiz_duration').val('');

        $('#passing_percentage').val('');

        $('#time_unit').val(1);

        $('#quizModal').modal('show');

        $('#step1').show();

        $('#step2').hide();

        $('#step3').hide();

        $('#nestedStep').hide();

        $('#nestedStep2').hide();

        $('#hidden_id4').val(topic_id);
      
      });

      let initial_insert = true;

      $("#quiz_title").change(function() {
        var quiz_title = $(this).val();
        var topic_id = $('#hidden_id4').val();
        var insert_type = 'insert';
        if(quiz_title !== '') {
          if(initial_insert) {
            insert_type = 'insert';
            initial_insert = false;
          } else {
            insert_type = 'update';
          }
          $.ajax({
            url: "courses_action.php",
            method: "POST",
            data: {action:'primary_quiz_add', quiz_title: quiz_title, topic_id: topic_id, insert_type: insert_type},
            dataType:'JSON',
            success:function(data) {
              $('#quiz_title').val(data.quiz_title);
              $('#quiz_container'+topic_id).html(data.data2);
              $('#quiz_id').html(data.quiz_id);
            }
          })
        }
      });
      let option_count = 1;

      $(".update_option").click(function() {
        var option_title = $('#option_title').val();
        var optionHtml = `
          <li class="nav-item py-2 border-bottom d-flex justify-content-between">
            <div contenteditable="true" data-option-id = "" class="option_title" id="option`+option_count+`">`+option_title+`</div>
            <div>
              <input type="radio" name="options" id="option1" value="`+option_title+`">
              <button type="button" data-option-id = "" class="btn btn-sm delete_option"><i class="fas fa-times"></i></button>
            </div>
          </li>
        `;
        option_count++;
        $("#option_container").append(optionHtml);
        $('#nestedStep2').hide();
        $('#nestedStep').show();
      });

      $(document).on("click", ".delete_option", function() 
      {
        var option_id = $(this).data('option-id');
        if(option_id !== '') 
        {
          $.ajax({
            url: "courses_action.php",
            method: "POST",
            data: {action:'delete_option', option_id: option_id},
            dataType:'JSON',
            success:function(data) {
              $('#option_container').html(data);
            }
          })
        }
        else
        {
          $(this).closest("li").remove();
        }
      });

      $('#option_form').on('submit', function(event) {
        event.preventDefault();
        var question = $('#question').val();
        var action4 = $('#action4').val();
        var options = [];
        $('.option_title').each(function() {
          var optionText = $(this).text();
          var option_id = $(this).data('option-id');
          options.push({
            text: optionText,
            option_id: option_id
          });
        });
        var correctOption = $('input[name="options"]:checked').val();

        if(correctOption === undefined)
        {
            $('#message2').html('<div class="alert alert-danger">Select a correct answer!</div>');

            setTimeout(function(){
            
              $('#message2').html('');
            
            }, 3000);
        }
        else
        {
            var data2 = {
              question: question,
              options: options,
              correct_option: correctOption,
              action: 'add_question',
              action4: action4
            };
          
            $.ajax({
                url: "courses_action.php",
                method: "POST",
                data: data2,
                dataType:'JSON',
                success:function(data) {
                  $('#question_container').html(data);
                  $('#nestedStep').hide();
                  $('#step2').show();
                }
            })
        }

      });

      $(document).on('click', '.delete_topic', function() {
        var topic_id = $(this).data('topic-id');
        if(confirm("Are you sure you want to remove it?"))
        {
          $.ajax({
            url: "courses_action.php",
            method: "POST",
            data: {action:'delete_topic', topic_id: topic_id},
            dataType:'JSON',
            success:function(data) {
              $('#topic_container').html(data);
            }
          })
        }
        
      });

      $(document).on('click', '.delete_material', function() {
        var material_id = $(this).data('material-id');
        var topic_id = $(this).data('topic-id');
        if(confirm("Are you sure you want to remove it?"))
        {
          $.ajax({
            url: "courses_action.php",
            method: "POST",
            data: {action:'delete_material', material_id: material_id, topic_id: topic_id},
            dataType:'JSON',
            success:function(data) {
              $('#topic'+topic_id).html(data);
            }
          })
        }
        
      });

      $(document).on('click', '.delete_quiz', function() {
        var quiz_id = $(this).data('quiz-id');
        var topic_id = $(this).data('topic-id');
        if(confirm("Are you sure you want to remove it?"))
        {
          $.ajax({
            url: "courses_action.php",
            method: "POST",
            data: {action:'delete_quiz', quiz_id: quiz_id, topic_id: topic_id},
            dataType:'JSON',
            success:function(data) {
              $('#quiz_container'+topic_id).html(data);
            }
          })
        }
        
      });

      $(document).on('click', '.edit_quiz', function() 
      {
          var quiz_id = $(this).data('quiz-id');

          $.ajax({

              url:"courses_action.php",
          
              method:"POST",
          
              data:{quiz_id:quiz_id, action:'fetch_quiz'},
          
              dataType:'JSON',
          
              success:function(data)
              {
                $('#quiz_title').val(data.quiz_title);

                currentStep = 1;
              
                $('#quizModal').modal('show');

                $('#step1').show();

                $('#step2').hide();

                $('#step3').hide();

                $('#nestedStep').hide();

                $('#nestedStep2').hide();
              
                $('#question_container').html(data.questions);

                $('#quiz_duration').val(data.quiz_duration);

                $('#time_unit').val(data.time_unit);

                $('#passing_percentage').val(data.passing_percentage);
              
              }
            
          })
      });

      $(document).on('click', '.update_quiz', function() {
          var quiz_duration = $('#quiz_duration').val();
          var time_unit = $('#time_unit').val();
          var passing_percentage = $('#passing_percentage').val();
          $.ajax({
            url: "courses_action.php",
            method: "POST",
            data: {action:'update_quiz', quiz_duration: quiz_duration*time_unit, passing_percentage: passing_percentage},
            dataType:'JSON',
            success:function(data) {
              $('#quizModal').hide();
            }
          })
      });

      $(document).on('click', '.edit_question', function() 
      {
        var question_id = $(this).data('question-id');

        $.ajax({
            url: "courses_action.php",
            method: "POST",
            data: {action:'edit_question', question_id: question_id},
            dataType:'JSON',
            success:function(data) {
              $('#step2').hide();
              $('#nestedStep').show();
              $('#question').val(data.question);
              $('#option_container').html(data.options);
              $('#action4').val('update');
            }
        })
      });

      $(document).on('click', '.delete_question', function() 
      {
        var question_id = $(this).data('question-id');
        if(confirm("Are you sure you want to remove it?"))
        {
          $.ajax({
            url: "courses_action.php",
            method: "POST",
            data: {action:'delete_question', question_id: question_id},
            dataType:'JSON',
            success:function(data) {
              $('#question_container').html(data);
            }
          })
        }
        
      });

      function calculateVideoDuration(file, callback) {
        var video = document.createElement('video');
        video.preload = 'metadata';
        video.onloadedmetadata = function() {
          window.URL.revokeObjectURL(video.src);
          var duration = video.duration;
          callback(duration);
        };
        video.src = URL.createObjectURL(file);
      }

      $('#upload_file').click(function() {
        var fileInput = $('#lesson_file')[0];
        var file = fileInput.files[0];
        if (file) {
          $('#progress').show();
          calculateVideoDuration(file, function(duration) {
            var formData = new FormData();
            formData.append('file', file);
            formData.append('duration', duration);
            formData.append('action', 'upload_lesson');

            $.ajax({
              url: 'courses_action.php',
              type: 'POST',
              data: formData,
              dataType:'JSON',
              processData: false,
              contentType: false,
              xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(evt) {
                  if (evt.lengthComputable) {
                    var percentComplete = (evt.loaded / evt.total) * 100;
                    $('#progress-bar').css('width', percentComplete + '%');
                    $('#progress-bar').attr('aria-valuenow', percentComplete);
                    $('#progress-bar').text(percentComplete+ ' %');
                  }
                }, false);
                return xhr;
              },
              success: function(data) {
                $('#hour').html(data.hour);
                $('#min').html(data.min);
                $('#sec').html(data.sec);
                $('#video_duration').val(data.duration);
                $('#video_container').html('<video width="300" height="180" controls src="'+data.file_name+'"></video>')
              }
            });
          });
        }
      });

      $('#youtube_video').change(function() 
      {
        $('#video_container').html($(this).val());
        var iframe = $('#video_container').find('iframe');
        iframe.attr('width', '300');
        iframe.attr('height', '180');
        getYouTubeVideoDuration();
      });

      $('#featured_video').change(function() {
        $('#featured_video_container').html($(this).val());
        var iframe2 = $('#featured_video_container').find('iframe');
        iframe2.css('width', '100%');
        iframe2.css('height', '200');
      })

      $('#user_image').change(function() {
        var output = document.getElementById('featured_image');
        output.src=URL.createObjectURL(event.target.files[0]);
      });

      $('#save_course').on('click', function() 
      {
        var editor = CKEDITOR.instances.course_info;
        var course_info = editor.getData();
        $('#course_info').val(course_info);

        var course_title = $('#course_title').val();
        var course_author = $('#course_author').val();
        var course_duration = $('#course_duration').val();
        var course_level = $('#course_level').val();
        var course_learning = $('#course_learning').val();
        var course_material = $('#course_material').val();
        var course_requirements = $('#course_requirements').val();
        var featured_video = $('#featured_video').val();
        var course_certificate = $('input[name=course_certificate]:checked').val();

        var file = $('#user_image')[0].files[0];

        var data = {
          course_title: course_title,
          course_info: course_info,
          course_author: course_author,
          course_duration: course_duration,
          course_level: course_level,
          course_learning: course_learning,
          course_material: course_material,
          course_requirements: course_requirements,
          featured_video: featured_video,
          course_certificate: course_certificate,
          action: 'save_course'
        };

        var formData = new FormData();
        formData.append('imageFile', file);

        for (var key in data) {
          formData.append(key, data[key]);
        }

        $.ajax({
            url: "courses_action.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success:function(data) 
            {
              $('#message').html(data);

            	setTimeout(function(){
              	$('#message').html('');
            	}, 5000);
            }
        })
      });

      $(document).on('click', '#delete_course', function(){
      
        if(confirm("Are you sure you want to remove it?"))
        {
        
            $.ajax({
            
              url:"courses_action.php",
            
              method:"POST",
            
              data:{action:'delete_course'},
            
              success:function(data)
              {
              
                  window.location.href = "courses.php";

              }
            
            })
          
        }

      });

      $(document).on('click', '#publish', function() {

        var admin_type = $(this).data('admin-type');

        var msg = '';

        if(admin_type === 'master') {
          msg = 'publish';
        }
        else
        {
          msg = 'submit';
        }

        if(confirm("Are you sure to "+msg+" it?"))
      	{

        		$.ajax({

          		url:"courses_action.php",

          		method:"POST",

          		data:{action:'publish', admin_type: admin_type},

              dataType:'JSON',

          		success:function(data)
          		{

            			if(data.publish)
                  {
                    $('#publish').html(data.submit2);
                    $('#publish').attr('disabled', 'disabled');
                  }
                  else
                  {
                    alert('Failed! Please add some course materials to '+msg+' it!');
                  }

          		}

        		})

      	}
      });

    });
  </script>

</body>

</html>
