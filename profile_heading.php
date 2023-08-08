    <div class="profile_heading d-flex justify-content-between align-items-center py-4 px-3 border-bottom border-2">
        <div class="profile_photo d-flex align-items-center">
            <img src="<?php echo $user_photo; ?>" class="img-rounded me-3" width="90" height="90" style="border-radius: 50%;">
            <div class="profile_name fs-4">
                Hello, <br> <span class="fw-bold"><?php echo $username; ?></span>
            </div>
        </div>
        <div id="instructor_control">
          <?php
            $object->query = "SELECT * FROM instructors WHERE student_id = '$user_id'";

            $object->execute();

            $total_row = $object->row_count();

            if($total_row > 0)
            {
              $result = $object->get_result();

              foreach($result as $row)
              {
                if($row["instructor_status"] == 'Pending')
                {
                  $request_on = $row["request_on"];
                  $date = new DateTime($request_on);
                  $request_on = $date->format('d F Y');
                  echo '<i class="fa-solid fa-circle-exclamation me-2 text-warning"></i> Your Application is pending as of <span class="fw-bold">'.$request_on.'</span>';
                }
                else if($row["instructor_status"] == 'Approved')
                {
                  echo '<a href="admin/course_edit.php?admin_type=instructor" class="btn btn-outline-primary"><i class="fa-regular fa-square-plus me-2"></i> Create Course</a>';
                }
              }
            }
            else
            {
              echo '<button class="btn btn-outline-primary" data-id="'.$user_id.'" id="instructor_request" type="button">Become an instructor</button>';
            }

          ?>
        </div>
    </div>