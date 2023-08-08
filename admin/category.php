<?php
include('header.php');
?>
        <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Category Management</h1>

        <span id="message"></span>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="row">
              	<div class="col">
                  <h4 class="m-0 font-weight-bold text-primary">Categories</h4>
              	</div>
              	<div class="col" align="right">
              		<button type="button" name="add_category" id="add_category" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
              	</div>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped" id="category_data" width="100%" cellspacing="0">
                    <thead>
                        <tr>	
                            <th>Category</th>
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

<div id="categoryModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="category_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Data</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
		          		<label>Category</label>
		          		<input type="text" name="category" id="category" class="form-control">
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

    var dataTable = $('#category_data').DataTable({
	  	"processing" : true,
	  	"serverSide" : true,
	  	"order" : [],
	  	"ajax" : {
	  		url:"category_action.php",
	  		type:"POST",
	  		data:{action:'fetch'}
	  	},
	  	"columnDefs":[
	  		{
	  			"targets":[2],
	  			"orderable":false,
	  		},
	  	],
	  });

    $('#add_category').click(function(){
		
		  $('#category_form')[0].reset();

    	$('#modal_title').text('Add Data');

    	$('#action').val('Add');

    	$('#submit_button').val('Add');

    	$('#categoryModal').modal('show');

    	$('#form_message').html('');

	  });

    $('#category_form').on('submit', function(event){
	  	event.preventDefault();	
	  		$.ajax({
	  			url:"category_action.php",
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
	  				if(data.error != '')
	  				{
	  					$('#form_message').html(data.error);
	  					$('#submit_button').val('Add');
	  				}
	  				else
	  				{
	  					$('#categoryModal').modal('hide');
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
    
      var category_id = $(this).data('id');
      
      $('#form_message').html('');
      
      $.ajax({
    
          url:"category_action.php",
    
          method:"POST",
    
          data:{category_id:category_id, action:'fetch_single'},
    
          dataType:'JSON',
    
          success:function(data)
          {
          
            $('#category').val(data.category);
          
            $('#modal_title').text('Edit Data');
          
            $('#action').val('Edit');
          
            $('#submit_button').val('Edit');
          
            $('#categoryModal').modal('show');
          
            $('#hidden_id').val(category_id);
          
          }
        
      })
    
    });

    $(document).on('click', '.status_button', function(){
	  	var id = $(this).data('id');
      var status = $(this).data('status');
	  	var next_status = 'Enable';
	  	if(status == 'Enable')
	  	{
	  		next_status = 'Disable';
	  	}
	  	if(confirm("Are you sure you want to "+next_status+" it?"))
      	{

        		$.ajax({

          		url:"category_action.php",

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
          
            url:"category_action.php",
          
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
