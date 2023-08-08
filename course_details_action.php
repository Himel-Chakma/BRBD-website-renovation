<?php
include('admin/main.php');
$object = new brbd();

if(isset($_POST["action"]))
{
    if($_POST["action"] == 'fetch_course')
    {
        $output = array();

        $object->query = "
        SELECT courses.*, instructors.* 
        FROM courses 
        INNER JOIN instructors 
        ON courses.course_author = instructors.instructor_id 
        WHERE course_id = '".$_POST["course_id"]."'";

        $result = $object->get_result();

        foreach($result as $row)
        {
            $output["course_title"] = $row["course_title"];
            if($row["featured_video"] == '')
            {
                $output["featured_photo"] = '<img src = "admin/'.$row["course_photo"].'" class="img-fluid rounded border">';
            }
            else
            {
                $output["featured_photo"] = '
                <div id="video_c">
                    <div class="spinner d-flex justify-content-center align-items-center" id="spinner-c" style="display:none;">
                        <div class="spinner-border text-primary" style="display:none;" id="spinner" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="video_container">
                        '.$row["featured_video"].'
                    </div>
                </div>
                ';
            }
            $output["course_info"] = $row["course_info"];
            $output["course_level"] = $row["course_level"];
            $hour = '';
            $min = '';
            if($row["course_duration"]) {
                $duration = $row["course_duration"];
                $hour = floor($duration/60);
                $min = $duration % 60;
            }
            $output["course_duration"] = $hour.' hour '.$min.' minute';
            $output["instructor_name"] = $row["instructor_name"];
            $output["instructor_photo"] = $row["instructor_photo"];

            $object->query = "SELECT category.* FROM courses INNER JOIN (category INNER JOIN category_to_courses ON category.category_id = category_to_courses.category_id) ON courses.course_id = category_to_courses.course_id WHERE courses.course_id = '".$row['course_id']."' ORDER BY category.category_name ASC";

			$result2 = $object->get_result();

			$category = array();

			foreach($result2 as $row2) {

				$category[] = $row2["category_name"];

			}

            $output["course_category"] = $object->clean_output($category);

            $lines = explode("\n", $row["course_materials"]);

            $lines = array_map('trim', $lines);

            $data = '';
            foreach ($lines as $line) {
                $data .= '<li class="py-2">' . htmlspecialchars($line) . '</li>';
            }

            $output["course_materials"] = $data;

            $lines = explode("\n", $row["course_requirements"]);

            $lines = array_map('trim', $lines);

            $data = '';
            foreach ($lines as $line) {
                $data .= '<li class="py-2">' . htmlspecialchars($line) . '</li>';
            }

            $output["course_requirements"] = $data;

            $lines = explode("\n", $row["course_learning"]);

            $lines = array_map('trim', $lines);

            $data = '';
            foreach ($lines as $line) {
                $data .= '<li class="py-2">' . htmlspecialchars($line) . '</li>';
            }

            $output["course_learning"] = $data;

            $object->query = "
		    SELECT * FROM topics 
		    WHERE course_id = '".$row["course_id"]."' ORDER BY topic_name ASC
		    ";
            
		    $result = $object->get_result();
            
		    $data2 = '';

            $i = 1;
            
		    foreach($result as $row)
		    {
		    	$object->query = "SELECT * FROM materials WHERE topic_id = '".$row["topic_id"]."'";
            
		    	$result2 = $object->get_result();

		    	$object->query = "SELECT * FROM quizes WHERE topic_id = '".$row["topic_id"]."'";
            
		    	$result3 = $object->get_result();
            
		    	$data2 .= '
                <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-heading'.$i.'">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse'.$i.'" aria-expanded="true" aria-controls="panelsStayOpen-collapse'.$i.'">
                  '.$row["topic_name"].'
                </button>
                </h2>
                <div id="panelsStayOpen-collapse'.$i.'" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading'.$i.'">
                    <div class="accordion-body">
                        <ul class="nav flex-column">
		    		  ';
		    		  foreach($result2 as $row2) 
		    		  {
		    			$icon = '';
                    
		    			if($row2["material_type"] == 'YouTube Video' || $row2["material_type"] == 'Video Lesson') 
		    			{
		    				$icon = '<i class="fa-brands fa-youtube me-2"></i>';
		    			}
		    			else
		    			{
		    				$icon = '<i class="fa-solid fa-file-powerpoint me-2"></i>';
		    			}
                        $duration2 = $row2["video_duration"];
                        $hour2 = '';
                        if($duration2 >= 3600)
                        {
                          $hour2 = floor($duration/3600);
                          $hour2 = $hour2.':';
                        }
                        $min2 = floor($duration2/60);
                        $sec2 = $duration2 % 60;

		    			$data2 .= '
		    			<li class="nav-item d-flex justify-content-between border-bottom py-2">
                            <div class="lesson_title"><i class="fa-brands fa-youtube me-2"></i> '.$row2["material_name"].'</div>
                            <div class="lesson_duration">'.$hour2.''.$min2.':'.$sec2.'</div>
                        </li>
		    			';
		    		  }
                  
		    		  $data2 .= '</ul>
                        <ul class="nav flex-column">
		    		  ';

		    		  foreach($result3 as $row3) {
		    			$data2 .= '
                        <li class="nav-item border-bottom py-2">
                            <div class="lesson_title"><i class="fa-regular fa-circle-question me-2"></i> '.$row3["quiz_title"].'</div>
                        </li>
		    			';
		    		  }

		    		  $data2 .= '</ul>
                            </div>
                        </div>
                    </div>
		    	';
                $i++;
		    }

            $output["course_material_details"] = $data2;
        }

        echo json_encode($output);
    }

    if($_POST["action"] == 'enroll_course')
    {
        sleep(2);
        $data = array(
            ':student_id'       => $_SESSION["user_id2"],
            ':course_id'        => $_POST["course_id"],
            ':enrolled_status'  => 'Enrolled',
            ':certificate_id'   => $object->generateRandomString()
        );
        $object->query = "INSERT INTO course_enrolled(student_id, course_id, enrolled_status, certificate_id)VALUES(:student_id, :course_id, :enrolled_status, :certificate_id)";

        $object->execute($data);

        $enrolled_id = $object->last_insert_id();

        $enrolled_id2 = $enrolled_id;

        $object->query = "SELECT * FROM topics WHERE course_id = '".$_POST["course_id"]."'";

        $object->execute();

        $total_row = $object->row_count();

        for($i = 1; $i <= $total_row; $i++)
        {
            $unlock_status = 'Locked';
            if($i == 1)
            {
                $unlock_status = 'Unlocked';
            }
            $object->query = "INSERT INTO topic_unlock(topic_serial, enrolled_id, unlock_status)VALUES('$i','$enrolled_id2','$unlock_status')";

            $object->execute();
        }

        $object->query = "
        SELECT m.material_id, m.material_type
        FROM materials m
        JOIN topics t ON m.topic_id = t.topic_id
        JOIN courses c ON t.course_id = c.course_id
        WHERE c.course_id = '".$_POST["course_id"]."' 
        AND m.material_type IN ('Video Lesson', 'Youtube Video');
        ";

        $result = $object->get_result();

        foreach($result as $row)
        {
            $material_id = $row["material_id"];

            $material_type = $row["material_type"];

            $object->query = "INSERT INTO material_status_table(material_id, enrolled_id, material_status, material_type)VALUES('$material_id', '$enrolled_id2', 'incomplete', '$material_type')";

            $object->execute();
        }

        $object->query = "
        SELECT m.quiz_id
        FROM quizes m
        JOIN topics t ON m.topic_id = t.topic_id
        JOIN courses c ON t.course_id = c.course_id
        WHERE c.course_id = '".$_POST["course_id"]."'
        ";

        $result = $object->get_result();

        foreach($result as $row)
        {
            $material_id = $row["quiz_id"];

            $object->query = "INSERT INTO material_status_table(material_id, enrolled_id, material_status, material_type)VALUES('$material_id', '$enrolled_id2', 'incomplete', 'quiz')";

            $object->execute();
        }

        $date = new DateTime();
        $enrolled_date = $date->format('d F Y');

        $data2 = '
            <h5 class="fw-bolder">Course Progress</h5>
              <div class="progress_container">
                <div class="progress_count my-3 d-flex justify-content-between">
                  <div>0/'.$total_row.'</div>
                  <div>0% Complete</div>
                </div>
                <div class="progress" style="height: 6px;">
                  <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
              <a href="course_lessons.php?course_id='.$_POST["course_id"].'"" class="btn btn-primary my-4 form-control">Start Leaning</a>
              <div class="course_enrolled_date">
                <i class="fa-solid fa-cart-arrow-down text-success"></i> You Enrolled this course on <span class="fw-bolder text-success">'.$enrolled_date.'</span>
            </div>
        ';

        echo json_encode($data2);
    }
}

?>