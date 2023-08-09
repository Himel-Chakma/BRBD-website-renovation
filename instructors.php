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
    
    



    <!-- course section -->
    <div class="container m-auto py-5">
        <div class="row">
            <div class="col d-flex justify-content-center align-items-center flex-column text-center custom-bg">
                <h1 class="text-white fw-bolder">Our Instructors</h1>
                <h6 class="text-white">Make learning and teaching more effective with active<br>participation and student collaboration</h6>
            </div>
        </div>
        <div class="row py-3">
          <?php
            $object->query = "SELECT * FROM instructors WHERE instructor_id != '10'";

            $result = $object->get_result();

            foreach($result as $row)
            {
              echo '
                <div class="col-md-3 p-3">
                    <div class="card course shadow">
                        <img class="border-bottom" style="border-top-right-radius: 6px; border-top-left-radius: 6px;" height="300" src="'.$row["instructor_photo"].'"></a>
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
                          <h5 class="card-title py-2 pb-4"><a href="" class="text-decoration-none text-reset fw-bold">'.$row["instructor_name"].'</a></h5>
                        </div>
                        <div class="card-footer">
                          <a href="" class="btn btn-primary form-control">View Profile</a>
                        </div>
                    </div>
                </div>
              ';
            }
          ?>
        </div>
    </div>


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