<?php
include('header.php');
?>
        <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Course Management</h1>

        <!-- DataTales Example -->
        <span id="message"></span>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="row">
                  <div class="col">
                    <h4 class="m-0 font-weight-bold text-primary">Course List</h4>
                  </div>
                  <div class="col" align="right">
                    <a href="course_edit.php" class="btn btn-success btn-sm text-white"><i class="fas fa-plus mr-2"></i> Add Course</a>
                  </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="course_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Course Title</th>
                                <th style="width: 15%;">Category</th>
                                <th>Author</th>
                                <th>Date Created</th>
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

    var dataTable = $('#course_table').DataTable({
	  	"processing" : true,
	  	"serverSide" : true,
	  	"order" : [],
	  	"ajax" : {
	  		url:"courses_action.php",
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

    $(document).on('click', '.status_button', function(){
	  	var id = $(this).data('id');
      var status = $(this).data('status');
	  	var next_status = 'Publish';
	  	if(status == 'Publish')
	  	{
	  		next_status = 'Pending';
	  	} 
	  	if(confirm("Are you sure you want to "+next_status+" it?"))
      	{

        		$.ajax({

          		url:"courses_action.php",

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
          
            url:"courses_action.php",
          
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
