<?php
include('main.php');
$object = new brbd();
include('header.php');
$course_id = '';
if(isset($_SESSION["course_id"])) {
  $course_id = $_SESSION["course_id"];
}
?>
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
                      <h4 class="m-0 font-weight-bold text-primary" id="course_heading_title">Add Course <span id="course_id"></span></h4>
                  </div>
                  <div clas="col" align="right">
                      <input type="hidden" name="course_id" value="<?php echo $course_id; ?>" />
                      <button type="submit" name="edit_button" id="edit_button" class="btn btn-warning btn-sm"><i class="fa fa-file" aria-hidden="true"></i> Save</button>
                      &nbsp;&nbsp;
                      <a href="" class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Preview</a>&nbsp;&nbsp;
                      <button type="button" id="publish" class="btn btn-primary btn-sm">Publish</button>&nbsp;&nbsp;
                      <button type="button" id="delete" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
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
                          $object->query = "SELECT instructors.* FROM instructors INNER JOIN courses ON courses.course_author = instructors.instructor_id WHERE courses.course_id = '".$course_id."'";

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
                          <label>Course Duration</label>
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
                      <div class="form-group" id="topic_container">
                        Add Title First to create course materials.
                      </div>
                      <div class="form-group">
                        <button type="button" class="btn btn-primary btn-sm" id="add_topic" disabled><i class="fas fa-plus mr-2"></i> Add Topic</button>
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
                          <label>Featured Image/Video</label><br />
                          <input type="file" name="user_image" id="user_image" />
                          <img src="img/3.jpg" class="img-fluid" alt="">
                      </div>
                      <div class="form-group">
                          <label>Material Includes</label>
                          <textarea name="course_material" id="course_material" rows="5" class="form-control"></textarea>
                      </div>
                      <div class="form-group">
                          <label>Requirements</label>
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
    	<form method="post" id="lesson_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Data</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
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
                    <option value="Power Point Slide">Power Point Slide</option>
                  </select>
                </div>
                <div class="form-group">
                  <!--<input type="file" name="lesson_file" id="lesson_file" class="form-control">-->
                </div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id2" id="hidden_id2" />
          			<input type="hidden" name="action" id="action2" value="Add_lesson" />
          			<input type="submit" name="submit" id="submit_button2" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
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


  <script>
  CKEDITOR.replace('course_info');
  </script>

  <script>
    $(document).ready(function() {

      $('#course_title').on("change", function(event) {
          event.preventDefault();
          var course_title = $(this).val();
          var course_author = $('#course_author').val();
            $.ajax({
              url: "courses_action.php",
              method: "POST",
              data: {action:'primary_add', course_title:course_title, course_author:course_author},
              dataType:'JSON',
              success:function(data) {
                $('#course_title').val(data.course_title);
                $('#course_author').val(data.course_author);
                $('#course_id').html(data.course_id);
                $('#add_topic').removeAttr('disabled');
                $("#addCategoryBtn").removeAttr('disabled');
                $('#topic_container').html('');
                $('#category_msg').html('');
              }
            }) 
      });

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
	    				$('#topic_container').html(data);
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
	    				$('#course_title').val(data.course_title);
              $('#course_info').val(data.course_info);
              $('#course_duration').val(data.course_duration);
              $('#course_level').val(data.course_level);
              $('#course_heading_title').html('Edit Course');
              $('#topic_container').html(data.course_materials);
              $('#categoryList').html(data.course_category);
              $('#category_msg').html('');
	    			}
	    		})
	    });

    });
  </script>

</body>

</html>
