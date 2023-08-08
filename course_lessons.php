<?php
include('admin/main.php');
$object = new brbd();
$got_course_id = '';
if(isset($_GET["course_id"])) 
{
    $got_course_id = $_GET["course_id"];
}
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
  .accordion2 {
    background-color: #edf6ff;
    cursor: pointer;
    padding: 12px 16px;
    width: 100%;
    border: 1px solid #ccc;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
    color: #007bff;
  }

  .accordion2:disabled {
    color: #ccc;
  }

  button.accordion2:first-of-type {
    border-top-right-radius: 6px;
    border-top-left-radius: 6px;
  }

  .panel2:last-of-type {
    border-bottom-right-radius: 6px;
    border-bottom-left-radius: 6px;
  }
  
  .active2, .accordion2:hover {
    background-color: #eee;
  }
  
  .accordion2:after {
    content: '\002B';
    color: #777;
    font-weight: bold;
    float: right;
    margin-left: 5px;
  }
  
  .active2:after {
    content: "\2212";
  }
  
  .panel2 {
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    border: 1px solid #ccc;
  }

  .custom_card {
    width: 100%;
  }

  #material_body {
    position: relative;
  }

  iframe {
    width: 100%;
    height: 300px;
  }

  .spinner {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 300px;
    z-index: 10;
  }

  button:disabled {
    border: none !important;
  }

  @media (min-width: 992px) {
    .custom_card {
      width: 50%;
    }

    iframe {
        width: 100%;
        height: 500px;
    }
    .spinner {
        height: 500px;
    }
  }
  </style>
<body>
    <?php
      include('navbar.php');
    ?>
    <div class="container m-auto">
        <div class="row">
          <div class="col-md-3 mb-3">
            <div class="p-2 px-3">
              <h5 class="fw-bolder">Couse Contents</h5>
            </div>
            <?php
                $object->query = "SELECT * FROM topics WHERE course_id = '$got_course_id' ORDER BY topic_serial ASC";

                $result = $object->get_result();

                $data = '';

                $object->query = "SELECT * FROM course_enrolled WHERE student_id = '".$_SESSION["user_id2"]."' AND course_id = '$got_course_id'";

                $result4 = $object->get_result();

                $enrolled_id = '';

                foreach($result4 as $row4)
                {
                    $enrolled_id = $row4["enrolled_id"];
                }

                foreach($result as $row)
                {
                    $object->query = "SELECT * FROM topic_unlock WHERE enrolled_id = '$enrolled_id' AND topic_serial = '".$row["topic_serial"]."'";

                    $result5 = $object->get_result();

                    $locked = 'disabled';

                    foreach($result5 as $row5)
                    {
                        if($row5["unlock_status"] == 'Unlocked')
                        {
                          $locked = '';
                        }
                    }
                    
                    $data .= '
                    <button class="accordion2">'.$row["topic_name"].'</button>
                    <div class="panel2" style="max-height: inherit;">
                      <div class="d-grid gap-2 p-2">
                    ';
                    $object->query = "SELECT * FROM materials WHERE topic_id = '".$row["topic_id"]."'";

                    $result2 = $object->get_result();

                    foreach($result2 as $row2)
                    {
                        $object->query = "SELECT * FROM material_status_table WHERE material_id = '".$row2["material_id"]."' AND enrolled_id = '$enrolled_id'";

                        $result6 = $object->get_result();

                        $material_status = '';

                        foreach($result6 as $row6)
                        {
                            $material_status = $row6["material_status"];

                            if($material_status == 'complete')
                            {
                                $material_status = '<i class="fa-sharp fa-regular fa-circle-check"></i>';
                            }
                            else
                            {
                                $material_status = '<i class="fa-sharp fa-regular fa-circle"></i>';
                            }
                        }
                        $duration = $row2["video_duration"];
                        $hour = '';
                        if($duration >= 3600)
                        {
                          $hour = floor($duration/3600);
                          $hour = $hour.':';
                        }
                        $min = floor(($duration%3600)/60);
                        $sec = $duration % 60;
                        $data .= '
                            <button type="button" style="font-size: 14px;" data-material-id = "'.$row2["material_id"].'" data-material-type = "video" class="btn d-flex justify-content-between py-1 materials topic'.$row["topic_serial"].'" '.$locked.'>
                                <div class="lesson_title d-flex" style="width: 80%; text-align: left;">
                                  <i class="fa-brands fa-youtube me-2 mt-1"></i> 
                                  '.$row2["material_name"].'
                                </div>
                                <div class="lesson_duration">'.$hour.''.$min.':'.$sec.' <span id="material_status'.$row2["material_id"].'">'.$material_status.'</span></div>
                            </button>
                            <hr class="m-0">
                        ';
                    }

                    $object->query = "SELECT * FROM quizes WHERE topic_id = '".$row["topic_id"]."'";
                  
                    $result3 = $object->get_result();
                  
                    foreach($result3 as $row3)
                    {
                        $object->query = "SELECT * FROM material_status_table WHERE material_id = '".$row3["quiz_id"]."' AND enrolled_id = '$enrolled_id'";

                        $result6 = $object->get_result();

                        $material_status = '';

                        foreach($result6 as $row6)
                        {
                            $material_status = $row6["material_status"];

                            if($material_status == 'complete')
                            {
                                $material_status = '<i class="fa-sharp fa-regular fa-circle-check"></i>';
                            }
                            else
                            {
                                $material_status = '<i class="fa-sharp fa-regular fa-circle"></i>';
                            }
                        }
                        $data .= '
                          <button type="button" style="font-size: 14px;" data-material-id = "'.$row3["quiz_id"].'" data-material-type = "quiz" class="btn d-flex justify-content-between py-1 materials topic'.$row["topic_serial"].'" '.$locked.'>
                              <div class="lesson_title"><i class="fa-regular fa-circle-question me-2"></i> '.$row3["quiz_title"].'</div>
                              <div class="lesson_duration"><span id="material_status'.$row3["quiz_id"].'">'.$material_status.'</span></div>
                          </button>
                          <hr class="m-0">
                        ';
                    }

                    $data .= '</div>
                    </div>';
                }

                echo $data;
            ?>
              
          </div>
          <div class="col-md-9">
            <div class="material_container" id="material_container">
              
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
  var acc = document.getElementsByClassName("accordion2");
  var i;
  
  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active2");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      } 
    });
  }
  </script>

  <script>
    $(document).ready(function() {

        var countdown;

        function timer(min) 
        {
            var minutes = min; 
            var seconds = minutes * 60;

            countdown = setInterval(function() {
              var minutesRemaining = Math.floor(seconds / 60);
              var secondsRemaining = seconds % 60;
            
              $('#timer').text(minutesRemaining + ' minutes ' + secondsRemaining + ' seconds');
            
              if (seconds === 0) {
                clearInterval(countdown);
                $('#timer').text('Time Finished');

                $('.submit_button').click();
              }
          
              seconds--;
            }, 1000);
        }

        var total_row = '';

        let currentStep;
        
        $(document).on('click', '#start_quiz', function() 
        {
            var quiz_id = $(this).data('quiz-id');

            currentStep = 1;

            $.ajax({

                url:"course_lessons_action.php",

                method:"POST",

                data:{quiz_id:quiz_id, action:'quiz_fetch'},

                dataType:'JSON',

                success:function(data)
                {
                    $('#quiz_heading').hide();
                    $('#quiz_container').show();
                    $('#quiz_form').html(data.details);
                    $('#question_count').text('1');
                    $('.previous-step').hide();
                    timer(data.quiz_duration);
                    total_row = data.total_row;
                }
            })
            
        });

        $(document).on('click', '.next-step', function() {
          if (currentStep < total_row) {
            $('#step' + currentStep).hide();
            currentStep++;
            $('#step' + currentStep).show();
            if(currentStep !== 1) {
              $('.previous-step').show();
            }
            $('#question_count').text(currentStep);

            if(currentStep === total_row) 
            {
                $('.submit_button').show();
                $('.next-step').hide();
            }
          }
        });

        $(document).on('click', '.previous-step', function() {
          if (currentStep > 1) {
            $('#step' + currentStep).hide();
            currentStep--;
            $('#step' + currentStep).show();
            if(currentStep === 1) {
              $('.previous-step').hide();
            }
            $('#question_count').text(currentStep);

            if(currentStep !== total_row) 
            {
                $('.submit_button').hide();
                $('.next-step').show();
            }
          }
        });

        $(document).on('submit', '#quiz_form', function(event) 
        {
            event.preventDefault();

            $.ajax({
	  		    	url:"course_lessons_action.php",
	  		    	method:"POST",
	  		    	data:$(this).serialize(),
              dataType:'JSON',
	  		    	beforeSend:function()
	  		    	{
	  		    		$('.submit_button').attr('disabled', 'disabled');
	  		    		$('.submit_button').val('wait...');
	  		    	},
	  		    	success:function(data)
	  		    	{
	  		    		$('.submit_button').attr('disabled', false);
                clearInterval(countdown);
	  		    		$('#quiz_container').hide();
                $('#quiz_result').show();
                $('#quiz_result').html(data.details);
                if(data.pass === 'Yes')
                {
                  $('.topic'+data.topic_serial).removeAttr('disabled');
                  $('#material_status'+data.quiz_id).html('<i class="fa-sharp fa-regular fa-circle-check"></i>');
                }
	  		    	}
	  		    })
        });

        $(document).on('click', '.materials', function() 
        {
            $('.materials').removeClass('btn-primary');

            $(this).addClass('btn-primary');

            var material_type = $(this).data('material-type');

            var material_id = $(this).data('material-id');

            $.ajax({
            
                url:"course_lessons_action.php",
                
                method:"POST",
                
                data:{material_id:material_id, action:'material_fetch', material_type: material_type},
                
                dataType:'JSON',
                
                success:function(data)
                {
                    $('#material_container').html(data);

                    $('#spinner-c').show();

                    $('#spinner-c').css('height','500px');

                    $('#spinner').show();

                    var youtubeIframe = $('#video_container').find('iframe');

                    youtubeIframe.on('load', function() {
                        $('#spinner').hide();
                        $('#spinner-c').hide();
                        $('#spinner-c').css('height','0px'); 
                    });

                }
            })
        });

        $('.materials:first').click();

        $(document).on('click', '.complete', function() {

            var material_id = $(this).data('material-id');
            var enrolled_id = $(this).data('enrolled-id');
            var button = $(this);

            $.ajax({

                url:"course_lessons_action.php",

                method:"POST",

                data:{material_id:material_id, action:'mark_as_complete', enrolled_id: enrolled_id},

                dataType:'JSON',

                success:function(data)
                {
                    $('#material_status'+material_id).html('<i class="fa-sharp fa-regular fa-circle-check"></i>');
                    
                    $('#percent_complete').html(data);

                    button.html('Completed');

                    button.attr('disabled', 'disabled');
                }
            })
        });

    });
  </script>


</body>

</html>