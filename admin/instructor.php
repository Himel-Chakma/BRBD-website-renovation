<?php
include('header.php');
?>
        <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Instructor Management</h1>

        <!-- DataTales Example -->
        <span id="message"></span>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="row">
                  <div class="col">
                    <h4 class="m-0 font-weight-bold text-primary">Instructor List</h4>
                  </div>
                  <div class="col" align="right">
                    <button type="button" name="add_instructor" id="add_instructor" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                  </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="instructor_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Instructor Name</th>
                                <th>Instructor Email</th>
                                <th>Total Courses</th>
                                <th>Comission Rate (%)</th>
                                <th>Status</th>          
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <div id="instructorModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="instructor_form" enctype="multipart/form-data">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Data</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
                  <div class="form-group">
                      <div class="row">
                          <label class="col-md-4 text-right">Instructor Name <span class="text-danger">*</span></label>
                          <div class="col-md-8">
                              <input type="text" name="instructor_name" id="instructor_name" class="form-control"  />
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="row">
                          <label class="col-md-4 text-right">Instructor Email <span class="text-danger">*</span></label>
                          <div class="col-md-8">
                              <input type="text" name="instructor_email" id="instructor_email" class="form-control"  />
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="row">
                          <label class="col-md-4 text-right">Commission Rate <span class="text-danger">*</span></label>
                          <div class="col-md-8">
                              <input type="text" name="instructor_commission" id="instructor_commission" class="form-control"  />
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="row">
                          <label class="col-md-4 text-right">Instructor Profile Photo <span class="text-danger">*</span></label>
                          <div class="col-md-8">
                              <input type="file" name="instructor_image" id="instructor_image" />
                              <span id="instructor_uploaded_image"></span>
                          </div>
                      </div>
                  </div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
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

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts 
  <script src="js/demo/datatables-demo.js"></script>-->

  <script>
  $(document).ready(function() {

    var dataTable = $('#instructor_table').DataTable({
	  	"processing" : true,
	  	"serverSide" : true,
	  	"order" : [],
	  	"ajax" : {
	  		url:"instructor_action.php",
	  		type:"POST",
	  		data:{action:'fetch'}
	  	},
	  	"columnDefs":[
	  		{
	  			"targets":[0,2,3,6],
	  			"orderable":false,
	  		},
	  	],
	  });

    $('#add_instructor').click(function(){
    
	  	$('#instructor_form')[0].reset();

      $('#modal_title').text('Add Data');

      $('#action').val('Add');

      $('#submit_button').val('Add');

      $('#instructorModal').modal('show');

      $('#form_message').html('');

      $('#instructor_uploaded_image').html('');

	  });


    $('#instructor_form').on('submit', function(event){

	  	  event.preventDefault();
	  		
	  		$.ajax({
	  			url:"instructor_action.php",
	  			method:"POST",
	  			data:new FormData(this),
	  			dataType:'json',
          contentType:false,
          processData:false,
	  			beforeSend:function()
	  			{
	  				$('#submit_button').attr('disabled', 'disabled');
	  				$('#submit_button').val('wait...');
	  			},
	  			success:function(data)
	  			{
	  				$('#submit_button').attr('disabled', false);
	  				if(data.error != '')
	  				{
	  					$('#form_message').html(data.error);
	  					$('#submit_button').val('Add');
	  				}
	  				else
	  				{
	  					$('#instructorModal').modal('hide');
	  					$('#message').html(data.success);
	  					dataTable.ajax.reload();

	  					setTimeout(function(){

	  			      $('#message').html('');

	  			    }, 5000);
	  				}
	  			}
	  		})
	  });

    $(document).on('click', '.edit_button', function(){
    
    var instructor_id = $(this).data('id');
    
    $('#form_message').html('');
    
    $.ajax({
    
          url:"instructor_action.php",
    
          method:"POST",
    
          data:{instructor_id:instructor_id, action:'fetch_single'},
    
          dataType:'JSON',
    
          success:function(data)
          {
          
            $('#instructor_name').val(data.instructor_name);
            $('#instructor_email').val(data.instructor_email);
            $('#instructor_commission').val(data.instructor_commission);
          
            $('#instructor_uploaded_image').html('<img src="'+data.instructor_profile+'" class="img-fluid img-thumbnail" width="75" height="75" /><input type="hidden" name="hidden_instructor_image" value="'+data.instructor_profile+'" />');
          
            $('#modal_title').text('Edit Data');
          
            $('#action').val('Edit');
          
            $('#submit_button').val('Edit');
          
            $('#instructorModal').modal('show');
          
            $('#hidden_id').val(instructor_id);
          
          }
        
      })
    
    });

    $(document).on('click', '.status_button', function(){
	  	var id = $(this).data('id');
      var status = $(this).data('status');
	  	var next_status = 'Approved';
	  	if(status == 'Approved')
	  	{
	  		next_status = 'Pending';
	  	}
	  	if(confirm("Are you sure you want to "+next_status+" it?"))
      	{

        		$.ajax({

          		url:"instructor_action.php",

          		method:"POST",

          		data:{id:id, action:'change_status', status:status, next_status:next_status},

          		success:function(data)
          		{

            			$('#message').html(data);

            			dataTable.ajax.reload();

            			setTimeout(function(){

              			$('#message').html('');

            			}, 5000);

          		}

        		})

      	}
	  });

    $(document).on('click', '.delete_button', function(){

      var id = $(this).data('id');

      if(confirm("Are you sure you want to remove it?"))
      {
      
          $.ajax({
          
            url:"instructor_action.php",
          
            method:"POST",
          
            data:{id:id, action:'delete'},
          
            success:function(data)
            {
            
                $('#message').html(data);
            
                dataTable.ajax.reload();
            
                setTimeout(function(){
                
                  $('#message').html('');
                
                }, 5000);
              
            }
          
          })
        
      }

    });

  });
  </script>

</body>

</html>
