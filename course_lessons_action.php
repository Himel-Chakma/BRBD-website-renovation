<?php
include('admin/main.php');
$object = new brbd();

if(isset($_POST["action"]))
{
    if($_POST["action"] == 'quiz_fetch')
    {
        $object->query = "SELECT * FROM questions WHERE quiz_id = '".$_POST["quiz_id"]."' ORDER BY RAND()";

        $_SESSION["quiz_id"] = $_POST["quiz_id"];

        $object->execute();

        $total_row = $object->row_count();

        $result = $object->get_result();
        $data = '';
        $count = 1;
        foreach($result as $row) 
        {
            $style = '';
            if($count != 1) {
                $style = 'display: none;';
            }
            $data .= '
            <div id="step'.$count.'" style="'.$style.'">
                <div class="question_title py-3">
                    <h5 class="fw-bolder">'.$count.'. '.$row["question"].'</h5>
                    <input type="hidden" name="question_id'.$row["question_id"].'" id="question_id" value="'.$row["question_id"].'"> 
                </div>
                <div class="options">
                    <div class="row">
            ';
            $object->query = "SELECT * FROM options WHERE question_id = '".$row["question_id"]."'";
            $resul2 = $object->get_result();
            $count2 = 1;
            foreach($resul2 as $row2) 
            {
                $data .= '
                    <div class="col-md-6 p-2">
                      <label for="option'.$row["question_id"].''.$count2.'" class="option form-control">
                        <input type="radio" name="option'.$row["question_id"].'" id="option'.$row["question_id"].''.$count2.'" value="'.$row2["option_title"].'"> '.$row2["option_title"].'
                      </label>
                    </div>
                ';
                $count2++;
            }
            $data .= '
                </div>
            </div>
            </div>';
            $count++;
        }

        $data .= '
        <button type="button" class="btn btn-primary mt-4 previous-step" id="next_question">Back</button>
        <button type="button" class="btn btn-primary mt-4 next-step" id="next_question">Save & Next</button>
        <input type="hidden" name="action" id="action" value="submit_quiz">
        <input type="submit" class="btn btn-primary mt-4 submit_button" id="submit_button" style="display: none;" value="Submit">
        '; 

        $object->query = "SELECT * FROM quizes WHERE quiz_id = '".$_POST["quiz_id"]."'";

        $result = $object->get_result();

        $quiz_duration = '';

        foreach($result as $row) 
        {
            $quiz_duration = $row["quiz_duration"];
        }

        $data2 = array(
            'details'       => $data,
            'total_row'     => $total_row,
            'quiz_duration' => $quiz_duration
        );

        echo json_encode($data2);
    }

    if($_POST["action"] == 'submit_quiz') 
    {
        $object->query = "SELECT * FROM questions WHERE quiz_id = '".$_SESSION["quiz_id"]."'";

        $result = $object->get_result();

        $object->execute();

        $total_questions = $object->row_count();

        $correct_answer = 0;

        foreach($result as $row)
        {
            $question_id = '';

            $answered_option = '';

            $question_id_text = "question_id" . $row["question_id"];
            if(isset($_POST[$question_id_text])) 
            {
                $question_id = $_POST[$question_id_text];
            }
            $option_text = "option" . $row["question_id"];
            if(isset($_POST[$option_text]))
            {
                $answered_option = $_POST[$option_text];
            }
            
            if($row["correct_option"] == $answered_option)
            {
                $correct_answer++;
            }

            $data = array(
                ':student_id'       => $_SESSION["user_id2"],
                ':question_id'      => $question_id,
                ':answered_option'  => $answered_option,
                ':quiz_id'          => $_SESSION["quiz_id"]
            );

            $object->query = "
            INSERT INTO quiz_participation(student_id, question_id, answered_option, quiz_id)VALUES(:student_id, :question_id, :answered_option, :quiz_id)
            ";

            $object->execute($data);
        }

        $object->query = "SELECT * FROM quizes WHERE quiz_id = '".$_SESSION["quiz_id"]."'";

        $result = $object->get_result();

        $quiz_title = '';

        $quiz_duration = '';

        $passing_percentage = '';

        $topic_id = '';

        foreach($result as $row)
        {
            $quiz_title = $row["quiz_title"];
            $quiz_duration = $row["quiz_duration"];
            $passing_percentage = $row["passing_percentage"];
            $topic_id = $row["topic_id"];
        }

        $passing_marks = floor($total_questions*((double)$passing_percentage/100));

        $wrong_answer = $total_questions - $correct_answer;

        $percentage = number_format(((double)$correct_answer/(double)$total_questions)*100, 2);

        $pass = '<button type="button" class="btn btn-danger btn-sm">Fail</button>';

        $message = '<span class="text-danger">Sorry! You have been failed! Better Luck for the next time</span>';

        $is_pass = 'No';

        $object->query = "SELECT topic_serial FROM topics WHERE topic_id = '$topic_id'";

        $result = $object->get_result();

        $topic_serial = '';

        foreach($result as $row)
        {
            $topic_serial = $row["topic_serial"] + 1;
        }

        if($correct_answer >= $passing_marks) 
        {
            $pass = '<button type="button" class="btn btn-success btn-sm">Pass</button>';
            $message = '<span class="text-success">Congratulations!! You have unlocked topic '.$topic_serial.'</span>';
            $is_pass = 'Yes';
        }

        $object->query = "SELECT enrolled_id FROM course_enrolled WHERE student_id = '".$_SESSION["user_id2"]."' AND course_id = '".$_SESSION["course_id"]."'";

        $result = $object->get_result();

        $enrolled_id = '';

        foreach($result as $row)
        {
            $enrolled_id = $row["enrolled_id"];
        }

        if($is_pass == 'Yes')
        {
            $object->query = "SELECT * FROM topic_unlock WHERE enrolled_id = '$enrolled_id'";

            $object->execute();

            $total_row = $object->row_count();

            $object->query = "UPDATE material_status_table SET material_status = 'complete' WHERE material_id = '".$_SESSION["quiz_id"]."' AND material_type = 'quiz'";

            $object->execute();

            if($total_row >= $topic_serial)
            {
                $object->query = "UPDATE topic_unlock SET unlock_status = 'Unlocked' WHERE topic_serial = '$topic_serial' AND enrolled_id = '$enrolled_id'";

                $object->execute();
            }
            else
            {
                $message = '<span class="text-success">Congratulations!! You have successfully completed all the quizes</span>';
            }
        }

        $data2 = '
        <h6>Quiz</h6>
        <h5 class="fw-bolder">'.$quiz_title.'</h5>
        <hr>
        <div class="row">
          <div class="col-md-3">Questions: <span class="fw-bold">'.$total_questions.'</span></div>
          <div class="col-md-3">Quiz Time: <span class="fw-bold">'.$quiz_duration.' minute</span></div>
          <div class="col-md-3">Total Marks: <span class="fw-bold">'.$total_questions.'</span></div>
          <div class="col-md-3">Passing Marks: <span class="fw-bold">'.$passing_marks.'</span></div>
        </div>
        <hr>
        <table class="table table-responsive table-bordered">
            <thead>
                <tr class="text-center">
                    <th>Questions</th>
                    <th>Correct Answered</th>
                    <th>Wrong Answered</th>
                    <th>Earned Marks</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td>'.$total_questions.'</td>
                    <td>'.$correct_answer.'</td>
                    <td>'.$wrong_answer.'</td>
                    <td>'.$correct_answer.' ('.$percentage.'%)</td>
                    <td>'.$pass.'</button></td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
          <p class="my-4 fs-3">'.$message.'</p>
        </div>
        ';

        $data = array(
            'details'       => $data2,
            'pass'          => $is_pass,
            'topic_serial'  => $topic_serial,
            'quiz_id'       => $_SESSION["quiz_id"]
        );

        echo json_encode($data);
    }

    if($_POST["action"] == 'material_fetch')
    {
        $data = '';

        if($_POST["material_type"] == 'video')
        {
            $object->query = "SELECT * FROM materials WHERE material_id = '".$_POST["material_id"]."'";

            $result = $object->get_result();

            $object->query = "SELECT enrolled_id FROM course_enrolled WHERE student_id = '".$_SESSION["user_id2"]."' AND course_id = '".$_SESSION["course_id"]."'";
            
            $result2 = $object->get_result();
            
            $enrolled_id = '';
            
            foreach($result2 as $row2)
            {
                $enrolled_id = $row2["enrolled_id"];
            }

            $object->query = "SELECT * FROM material_status_table WHERE enrolled_id = '$enrolled_id'";
            
            $object->execute();
        
            $total_lesson = $object->row_count();
        
            $object->query = "SELECT * FROM material_status_table WHERE enrolled_id = '$enrolled_id' AND material_status = 'complete'";
        
            $object->execute();
        
            $lesson_completed = $object->row_count();
        
            $percent_completed = floor(($lesson_completed/$total_lesson)*100);

            $object->query = "SELECT * FROM material_status_table WHERE enrolled_id = '$enrolled_id' AND material_id = '".$_POST["material_id"]."'";

            $result3 = $object->get_result();

            $material_status = '';

            foreach($result3 as $row3)
            {
                $material_status = $row3["material_status"];
            }

            if($material_status == 'complete')
            {
                $material_status = '<button class="btn btn-outline-secondary text-white ms-2" style="border-color: white;" disabled>Completed</button>';
            }
            else
            {
                $material_status = '<button class="btn btn-outline-secondary text-white ms-2 complete" data-enrolled-id = "'.$enrolled_id.'" data-material-id = "'.$_POST["material_id"].'" style="border-color: white;">Mark as complete</button>';
            }
    
            foreach($result as $row)
            {
                $material_type = $row["material_type"];
    
                if($material_type == 'YouTube Video')
                {
                    $data = '
                        <div id="material_heading">
                            <div class="course_title_container bg-primary d-flex p-2 px-3 justify-content-between">
                                <div class="first d-flex align-items-center">
                                  <a href="course_details.php" class="btn btn-secondary btn-sm me-2 d-flex justify-content-center align-items-center" style="border: none; width: 35px; height: 35px; border-radius: 50%; background-color: #0057b5;"><i class="fa-solid fa-chevron-left"></i></a href="course_details.php">
                                  <div class="text-white"></div>
                                </div>
                                <div class="second d-flex align-items-center">
                                  <div class="text-white">Your Progress: <span id="percent_complete">'.$percent_completed.'</span>%</div>
                                  '.$material_status.'
                                </div>
                            </div>
                        </div>

                        <div id="material_body">
                            <div class="spinner d-flex justify-content-center align-items-center" id="spinner-c" style="display:none;">
                                <div class="spinner-border text-primary" style="display:none;" id="spinner" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="lesson_video" id="video_container">
                                '.$row["material_link"].'
                            </div>
                            <div class="about_section p-5">
                                <h3 class="fw-bolder">About</h3>
                                <p class="py-3">'.$row["material_info"].'</p>
                            </div>
                        </div>
                    ';
                }
            }
        }
        else
        {
            $object->query = "SELECT * FROM quizes WHERE quiz_id = '".$_POST["material_id"]."'";

            $result = $object->get_result();
    
            foreach($result as $row)
            {
                $object->query = "SELECT * FROM questions WHERE quiz_id = '".$row["quiz_id"]."'";

                $object->execute();

                $total_row = $object->row_count();

                $details = '
                    <div class="my-3 text-center">Will be available soon!</div>
                ';

                if($total_row > 0)
                {
                    $details = '
                        <div class="quiz_details mb-3">
                            <ul class="nav flex-column">
                              <li class="nav-item py-2">Questions: <span class="fw-bold">'.$total_row.'</span></li>
                              <li class="nav-item py-2">Quiz Time: <span class="fw-bold">'.$row["quiz_duration"].' minute</span></li>
                              <li class="nav-item py-2">Passing Grade: <span class="fw-bold">'.$row["passing_percentage"].'%</span></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-primary" data-quiz-id = "'.$row["quiz_id"].'" id="start_quiz">Start Quiz</button>
                    ';
                }

                $data = '
                    <div class="quiz_heading" id="quiz_heading">
                        <div class="d-flex justify-content-center align-items-center">
                          <div class="card mx-3 my-5 custom_card">
                            <div class="card-body p-5">
                              <h6>Quiz</h6>
                              <h4 class="fw-bolder">'.$row["quiz_title"].'</h4>
                              <hr>
                              '.$details.'
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="quiz_container p-5" id="quiz_container" style="display: none;">
                        <div class="quiz_top_bar d-flex justify-content-between">
                          <div class="questions">Questions: <span class="fw-bolder"><span id="question_count">1</span>/<span id="total_question">'.$total_row.'</span></span></div>
                          <div class="time_remaining">Time remaining: <span class="fw-bolder" id="timer"></span></div>
                        </div>
                        <form method="post" id="quiz_form">

                        </form>
                    </div>
                    <div class="quiz_result p-5" id="quiz_result" style="display: none;">

                    </div>
                ';
            }
        }

        echo json_encode($data);
    }

    if($_POST["action"] == 'mark_as_complete')
    {
        $data = array(
            ':material_id'  => $_POST["material_id"],
            ':enrolled_id'  => $_POST["enrolled_id"]
        );

        $object->query = "
        UPDATE material_status_table 
        SET material_status = 'complete' 
        WHERE material_id = :material_id AND enrolled_id = :enrolled_id;
        ";

        $object->execute($data);

        $object->query = "SELECT * FROM material_status_table WHERE enrolled_id = '".$_POST["enrolled_id"]."'";
            
        $object->execute();
    
        $total_lesson = $object->row_count();
    
        $object->query = "SELECT * FROM material_status_table WHERE enrolled_id = '".$_POST["enrolled_id"]."' AND material_status = 'complete'";
    
        $object->execute();
    
        $lesson_completed = $object->row_count();
    
        $percent_completed = floor(($lesson_completed/$total_lesson)*100);

        if($percent_completed == 100)
        {
            $object->query = "UPDATE course_enrolled SET enrolled_status = 'Completed' WHERE enrolled_id = '".$_POST["enrolled_id"]."'";

            $object->execute();
        }

        echo json_encode($percent_completed);
    }

}
?>