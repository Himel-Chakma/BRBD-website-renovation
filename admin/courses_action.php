<?php
include('main.php');
$object = new brbd();

if(isset($_POST["action"])) {

    if($_POST["action"] == 'fetch') 
	{

        $order_column = array('course_title', 'course_status');

		$output = array();

		$main_query = "SELECT courses.*, instructors.* FROM courses INNER JOIN instructors ON courses.course_author = instructors.instructor_id ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE course_title LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR course_status LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY course_id DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query;

		$result = $object->get_result();

		$object->query = $main_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

        foreach ($result as $row) {

			$object->query = "SELECT category.* FROM courses INNER JOIN (category INNER JOIN category_to_courses ON category.category_id = category_to_courses.category_id) ON courses.course_id = category_to_courses.course_id WHERE courses.course_id = '".$row['course_id']."' ORDER BY category.category_name ASC";

			$result2 = $object->get_result();

			$category = array();

			foreach($result2 as $row2) {

				$category[] = $row2["category_name"];

			}

			$object->query = "
			SELECT
			courses.course_id,
			courses.course_title,
			COUNT(DISTINCT topics.topic_id) AS total_topics,
			COUNT(DISTINCT materials.material_id) AS total_lessons,
			COUNT(DISTINCT quizes.quiz_id) AS total_quizzes
		  	FROM
				courses
		  	LEFT JOIN
				topics ON courses.course_id = topics.course_id
		  	LEFT JOIN
				materials ON topics.topic_id = materials.topic_id
		  	LEFT JOIN
				quizes ON topics.topic_id = quizes.topic_id
			WHERE courses.course_id = '".$row['course_id']."'
		  	GROUP BY
			courses.course_id,
			courses.course_title
			";

			$result3 = $object->get_result();

			$details = '';

			foreach($result3 as $row3) {
				$details = '
				<table>
					<tr>
						<th>Topics:</th>
						<th>Lessons:</th>
						<th>Quizzes:</th>
					</tr>
					<tr>
						<td>'.$row3["total_topics"].'</td>
						<td>'.$row3["total_lessons"].'</td>
						<td>'.$row3["total_quizzes"].'</td>
					</tr>
				</table>
				';
			}

            $sub_array = array();

			$sub_array[] = '<img src="'.$row["course_photo"].'" style="border: none;" class="img-fluid img-thumbnail" width="75" height="75" />';

            $sub_array[] = '<h5 class="font-weight-bold">'.$row["course_title"].'</h5>'.$details.'';

			$sub_array[] = $object->clean_output($category);

			$sub_array[] = '<img src="'.$row["instructor_photo"].'" style="border: none;" class="img-thumbnail rounded-circle" width="50" height="50" /> '.$row["instructor_name"].'';

			$sub_array[] = $row["course_created"];

            $status = '';

			if($row["course_status"] == 'Publish')
			{
				$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["course_id"].'" data-status="'.$row["course_status"].'">Published</button>';
			} 
			else if($row["course_status"] == 'Draft') 
			{
				$status = '<button type="button" name="status_button" class="btn btn-success btn-sm status_button" disabled>Draft</button>';
			}
			else
			{
				$status = '<button type="button" name="status_button" class="btn btn-warning btn-sm status_button" data-id="'.$row["course_id"].'" data-status="'.$row["course_status"].'">Pending</button>';
			}
			$sub_array[] = $status;
            $sub_array[] = '
			<div align="center">
			<a href="course_edit.php?course_id='.$row["course_id"].'" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" ><i class="fas fa-edit"></i></a>
			&nbsp;
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["course_id"].'" data-status="'.$row["course_status"].'"><i class="fas fa-times"></i></button>
			</div>
			';
			$data[] = $sub_array;
        }

        $output = array(
            "draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);
    }

    if($_POST["action"] == 'primary_add')
	{
		if($_POST["insert_type"] == 'insert') 
		{
			$data = array(
				':course_title'		=>	$_POST["course_title"],
				':course_author'	=>	$_POST["course_author"],
				':course_status'	=>	'Draft'
			);
	
			$object->query = "INSERT INTO courses(course_title,course_author,course_status)VALUES(:course_title, :course_author, :course_status)";
			$object->execute($data);
	
			$_SESSION["course_id"] = $object->last_insert_id();
		}
		else
		{
			$object->query = "
			UPDATE courses SET 
			course_title = '".$_POST["course_title"]."' 
			WHERE course_id = '".$_SESSION["course_id"]."'";

			$object->execute();
		}

		$output = array(
			'course_title'		=>	$_POST["course_title"],
			'course_author'		=>	$_POST["course_author"],
			'course_id'			=> 	$_SESSION["course_id"]
		);

		echo json_encode($output);

	}

    if($_POST["action"] == 'Add_topic')
	{
		$object->query = "SELECT * FROM topics WHERE course_id = '".$_SESSION["course_id"]."'";

		$object->execute();

		$total_rows = $object->row_count();

		$data = array(
			':topic_name'		=>	$_POST["topic"],
			':course_id'		=>	$_SESSION["course_id"],
			':topic_serial'		=>	$total_rows + 1
		);

		$object->query = "INSERT INTO topics(topic_name,course_id, topic_serial)VALUES(:topic_name, :course_id, :topic_serial)";

		$object->execute($data);

		echo json_encode($object->material_fetch($_SESSION["course_id"]));

	}

	if($_POST["action"] == 'Edit_topic')
	{
		$data = array(
			':topic_name'		=>	$_POST["topic"],
			':topic_id'			=>	$_POST["hidden_id"]
		);

		$object->query = "UPDATE topics SET topic_name = :topic_name WHERE topic_id = :topic_id";

		$object->execute($data);

		echo json_encode($object->material_fetch($_SESSION["course_id"]));
	}

	if($_POST["action"] == 'fetch_single_topic')
	{
		$object->query = "SELECT * FROM topics WHERE topic_id = '".$_POST["topic_id"]."'";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['topic_name'] = $row['topic_name'];
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'update_topic_serial')
	{
		$sortedIDs = $_POST['sortedIDs'];

		foreach ($sortedIDs as $index => $id) 
		{
		  $serialNumber = $index + 1;

		  $object->query = "UPDATE topics SET topic_serial = '$serialNumber' WHERE topic_id = '$id'";

		  $object->execute();
		}
	}

	if($_POST["action"] == 'Add_lesson')
	{
		$material_link = '';

		$video_duration = 0.00;

		if(isset($_FILES["doc_file"])) 
		{
			$material_link = $_FILES['doc_file']['name'];
		}
		if(isset($_FILES["lesson_file"])) 
		{
			$material_link = $_FILES['lesson_file']['name'];
		}
		if(isset($_POST["youtube_video"]))
		{
			$material_link = $_POST["youtube_video"];
		}
		if(isset($_POST["video_duration"])) 
		{
			$video_duration = $_POST["video_duration"];
		}

		$data = array(
			':topic_id'			=>	$_POST["hidden_id2"],
			':lesson_name'		=>	$_POST["lesson"],
			':lesson_info'		=> 	$_POST["lesson_info"],
			':lesson_type'		=>	$_POST["lesson_type"],
			':material_link'	=>	$material_link,
			':video_duration'	=>	$video_duration
		);

		$object->query = "INSERT INTO materials(material_name,material_info,material_type, material_link, video_duration, topic_id)VALUES(:lesson_name, :lesson_info, :lesson_type, :material_link, :video_duration, :topic_id)";

		$object->execute($data);

		$object->query = "
		SELECT * FROM materials 
		WHERE topic_id = '".$_POST["hidden_id2"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$icon = '';

			if($row["material_type"] == 'YouTube Video' || $row["material_type"] == 'Video Lesson') 
			{
				$icon = '<i class="fa-brands fa-youtube me-2"></i>';
			}
			else
			{
				$icon = '<i class="fa-solid fa-file-powerpoint me-2"></i>';
			}

			$data[] = '
				<li class="nav-item py-2 border-bottom">
					<div class="d-flex justify-content-between align-items-center">
					  <div>'.$icon.' '.$row["material_name"].'</div>
					  <div class="div">
						<button type="button" name="edit_button" data-material-id="'.$row["material_id"].'" data-topic-id="'.$row["topic_id"].'" id="edit_button" class="btn btn-outline-primary btn-circle btn-sm edit_material"><i class="fas fa-edit"></i></button>
						&nbsp;
						<button type="button" name="delete_button" data-material-id="'.$row["material_id"].'" data-topic-id="'.$row["topic_id"].'" id="delete_button" class="btn btn-outline-danger btn-circle btn-sm delete_material"><i class="fas fa-times"></i></button>
					  </div>
					</div>
				</li>
			';
		}

		echo json_encode($data);

	}

	if($_POST["action"] == 'Edit_material')
	{
		$material_link = '';

		$video_duration = 0.00;

		if(isset($_FILES["doc_file"])) 
		{
			$material_link = $_FILES['doc_file']['name'];
		}
		if(isset($_FILES["lesson_file"])) 
		{
			$material_link = $_FILES['lesson_file']['name'];
		}
		if(isset($_POST["youtube_video"]))
		{
			$material_link = $_POST["youtube_video"];
		}
		if(isset($_POST["video_duration"])) 
		{
			$video_duration = $_POST["video_duration"];
		}

		$data = array(
			':material_id'			=>	$_POST["hidden_id3"],
			':material_name'		=>	$_POST["lesson"],
			':material_info'		=> 	$_POST["lesson_info"],
			':material_type'		=>	$_POST["lesson_type"],
			':material_link'		=>	$material_link,
			':video_duration'		=>	$video_duration
		);

		$object->query = "
		UPDATE materials SET material_name = :material_name,
		material_info = :material_info, material_type = :material_type,
		material_link = :material_link, video_duration = :video_duration 
		WHERE material_id = :material_id;
		";

		$object->execute($data);

		$object->query = "
		SELECT * FROM materials 
		WHERE topic_id = '".$_POST["hidden_id2"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$icon = '';

			if($row["material_type"] == 'YouTube Video' || $row["material_type"] == 'Video Lesson') 
			{
				$icon = '<i class="fa-brands fa-youtube me-2"></i>';
			}
			else
			{
				$icon = '<i class="fa-solid fa-file-powerpoint me-2"></i>';
			}

			$data[] = '
				<li class="nav-item py-2 border-bottom">
					<div class="d-flex justify-content-between align-items-center">
					  <div>'.$icon.' '.$row["material_name"].'</div>
					  <div class="div">
						<button type="button" name="edit_button" data-material-id="'.$row["material_id"].'" data-topic-id="'.$row["topic_id"].'" id="edit_button" class="btn btn-outline-primary btn-circle btn-sm edit_material"><i class="fas fa-edit"></i></button>
						&nbsp;
						<button type="button" name="delete_button" data-material-id="'.$row["material_id"].'" data-topic-id="'.$row["topic_id"].'" id="delete_button" class="btn btn-outline-danger btn-circle btn-sm delete_material"><i class="fas fa-times"></i></button>
					  </div>
					</div>
				</li>
			';
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'fetch_single_material')
	{
		$object->query = "SELECT * FROM materials WHERE material_id = '".$_POST["material_id"]."'";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['lesson_name'] = $row['material_name'];
			$data['lesson_info'] = $row['material_info'];
			$data['lesson_type'] = $row['material_type'];
			$data['material_link'] = $row['material_link'];
			$data['video_duration'] = $row['video_duration'];
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'add_category')
	{
		$category_id = '';

		if(isset($_POST["category"])) 
		{
			$category_id = $_POST["category"];
		}

		if(isset($_POST["new_category"])) 
		{
			$data = array(
				':category_name' 	=> $_POST["new_category"],
				':category_status'	=> 'Enable'
			);

			$object->query = "INSERT INTO category(category_name,category_status)VALUES(:category_name, :category_status)";

			$object->execute($data);

			$category_id = $object->last_insert_id();
		}

		$data = array(
			':category_id'			=>	$category_id,
			':course_id'			=>	$_SESSION["course_id"]
		);

		$object->query = "INSERT INTO category_to_courses(category_id,course_id)VALUES(:category_id, :course_id)";

		$object->execute($data);

		$object->query = "
		SELECT category.* FROM category 
		INNER JOIN category_to_courses 
		ON category.category_id = category_to_courses.category_id 
		WHERE category_to_courses.course_id = '".$_SESSION["course_id"]."'";

		$result = $object->get_result();

		$data2 = '';

		foreach($result as $row) {
			$data2 .= '
				<li class="d-flex justify-content-between align-items-center nav-link">
					<div>
						<input class="mr-2" type="checkbox" checked> '.$row["category_name"].'
					</div>
					<div>
						<button type="button" data-category-id = "'.$row["category_id"].'" class="btn delete_category"><i class="fas fa-times"></i></button>
					</div>
				</li>
			';
		}

		echo json_encode($data2);
	}

	if($_POST["action"] == 'delete_category')
	{
		$object->query = "DELETE FROM category_to_courses WHERE category_id = '".$_POST["category_id"]."' AND course_id = '".$_SESSION["course_id"]."'";

		$object->execute();

		$object->query = "
		SELECT category.* FROM category 
		INNER JOIN category_to_courses 
		ON category.category_id = category_to_courses.category_id 
		WHERE category_to_courses.course_id = '".$_SESSION["course_id"]."'";

		$result = $object->get_result();

		$data2 = '';

		foreach($result as $row) {
			$data2 .= '
				<li class="d-flex justify-content-between align-items-center nav-link">
					<div>
						<input class="mr-2" type="checkbox" checked> '.$row["category_name"].'
					</div>
					<div>
						<button type="button" data-category-id = "'.$row["category_id"].'" class="btn delete_category"><i class="fas fa-times"></i></button>
					</div>
				</li>
			';
		}

		echo $data2;
	}

	if($_POST["action"] == 'fetch_course')
	{
		$output = array();

		$object->query = "SELECT courses.*, instructors.instructor_name FROM courses INNER JOIN instructors ON courses.course_author = instructors.instructor_id WHERE courses.course_id = '".$_SESSION["course_id"]."'";

		$result = $object->get_result();

		foreach($result as $row) {
			$output["course_title"] = $row["course_title"];
			$output["course_info"] = $row["course_info"];
			$output["course_author"] = $row["course_author"];
			$output["course_level"] = $row["course_level"];
			$output["course_duration"] = $row["course_duration"];
			$output["course_materials2"] = $row["course_materials"];
			$output["course_requirements"] = $row["course_requirements"];
			$output["course_learning"] = $row["course_learning"];
			$output["course_photo"] = $row["course_photo"];
			$output["course_id"] = $row["course_id"];
			$output["featured_video"] = $row["featured_video"];
			$output["course_certificate"] = $row["course_certificate"];

			$output["course_materials"] = $object->material_fetch($_SESSION["course_id"]);

			$object->query = "
			SELECT category.* FROM category 
			INNER JOIN category_to_courses 
			ON category.category_id = category_to_courses.category_id 
			WHERE category_to_courses.course_id = '".$_SESSION["course_id"]."'";

			$result4 = $object->get_result();

			$data3 = '';

			foreach($result4 as $row4) {
				$data3 .= '
				<li class="d-flex justify-content-between align-items-center nav-link">
					<div>
						<input class="mr-2" type="checkbox" checked> '.$row4["category_name"].'
					</div>
					<div>
						<button type="button" data-category-id = "'.$row4["category_id"].'" class="btn delete_category"><i class="fas fa-times"></i></button>
					</div>
				</li>
				';
			}

			$output["course_category"] = $data3;
		}

		echo json_encode($output);
	}

	if($_POST["action"] == 'primary_quiz_add') 
	{

		if($_POST["insert_type"] == 'insert') 
		{
			$data = array(
				':quiz_title'	=> $_POST["quiz_title"],
				':topic_id'		=> $_POST["topic_id"]
			);
			$object->query = "INSERT INTO quizes(quiz_title, topic_id)VALUES(:quiz_title, :topic_id)";
	
			$object->execute($data);

			$_SESSION["quiz_id"] = $object->last_insert_id();

		} 
		else 
		{
			if(isset($_POST["quiz_id"])) 
			{
				$quiz_id = $_POST["quiz_id"];
			} 
			else
			{
				$quiz_id = $_SESSION["quiz_id"];
			}
			$data = array(
				':quiz_title'	=> $_POST["quiz_title"],
				':quiz_id'		=> $quiz_id
			);

			$object->query = "UPDATE quizes SET quiz_title = :quiz_title WHERE quiz_id = :quiz_id";

			$object->execute($data);
		}

		$object->query = "SELECT * FROM quizes WHERE topic_id = '".$_POST["topic_id"]."'";
		
		$result = $object->get_result();

		$data2 = '';

		foreach($result as $row) 
		{
			$data2 .= '
			<li class="nav-item py-2 border-bottom">
			<div class="d-flex justify-content-between align-items-center">
			  <div><i class="fa-regular fa-circle-question me-2"></i> '.$row["quiz_title"].'</div>
			  <div class="div">
				<button type="button" name="edit_button" data-quiz-id="'.$row["quiz_id"].'" data-topic-id="'.$row["topic_id"].'" id="edit_quiz" class="btn btn-outline-primary btn-circle btn-sm edit_quiz"><i class="fas fa-edit"></i></button>
				&nbsp;
				<button type="button" name="delete_button" data-quiz-id="'.$row["quiz_id"].'" data-topic-id="'.$row["topic_id"].'" id="delete_quiz" class="btn btn-outline-danger btn-circle btn-sm delete_quiz"><i class="fas fa-times"></i></button>
			  </div>
			</div>
			</li>
			';
		}

		$data = array(
			'quiz_title'	=> $_POST["quiz_title"],
			'data2'			=> $data2,
			'quiz_id'		=> $_SESSION["quiz_id"]
		);

		echo json_encode($data);
	}

	if($_POST["action"] == 'add_question') 
	{
		$question = $_POST["question"];
		$options = $_POST["options"];
		$correct_option = $_POST["correct_option"];
		$quiz_id = $_SESSION["quiz_id"];

		if($_POST["action4"] == 'add') 
		{
			$object->query = "INSERT INTO questions(question,correct_option,quiz_id)VALUES('$question','$correct_option','$quiz_id')";
			$object->execute();
			$question_id = $object->last_insert_id();

			foreach($options as $option) {
				$option_title = $option["text"];

				$object->query = "INSERT INTO options(option_title, question_id)VALUES('$option_title','$question_id')";

				$object->execute();
			}
		}

		if($_POST["action4"] == 'update') 
		{
			$question_id = $_SESSION["question_id"];

			$object->query = "
			UPDATE questions SET 
			question = '$question',
			correct_option = '$correct_option' 
			WHERE question_id = '$question_id'";

			$object->execute();

			foreach($options as $option) 
			{
				$option_title = $option["text"];

				$option_id = $option["option_id"];

				if($option_id == '') 
				{
					$object->query = "INSERT INTO options(option_title, question_id)VALUES('$option_title','$question_id')";

					$object->execute();
				}
				else
				{
					$object->query = "UPDATE options SET option_title = '$option_title' WHERE option_id = '$option_id'";

					$object->execute();
				}
			}
		}

		$object->query = "SELECT * FROM questions WHERE quiz_id = '$quiz_id'";

		$result = $object->get_result();

		$data = '';

		foreach($result as $row) 
		{
			$data .= '
				<li class="nav-item py-2 border-bottom d-flex justify-content-between">
				<div class="question_title">'.$row["question"].'</div>
				<div>
				  <button type="button" id="edit_option" data-question-id = "'.$row["question_id"].'" class="btn btn-sm edit_question"><i class="fas fa-edit"></i></button>
				  <button type="button" id="delete_option" data-question-id = "'.$row["question_id"].'" class="btn btn-sm delete_question"><i class="fas fa-times"></i></button>
				</div>
				</li>
			';
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'edit_question') 
	{
		$_SESSION["question_id"] = $_POST["question_id"];

		$object->query = "SELECT * FROM questions WHERE question_id = '".$_POST["question_id"]."'";

		$result = $object->get_result();

		$question = '';

		$correct_option = '';

		foreach($result as $row) 
		{
			$question = $row["question"];
			$correct_option = $row["correct_option"];	
		}

		$object->query = "SELECT * FROM options WHERE question_id = '".$_POST["question_id"]."'";

		$result = $object->get_result();

		$options = '';

		foreach($result as $row) 
		{
			$is_correct = '';

			if($correct_option == $row["option_title"]) 
			{
				$is_correct = 'checked';
			}
			$options .= '
				<li class="nav-item py-2 border-bottom d-flex justify-content-between">
        		    <div contenteditable="true" data-option-id = "'.$row["option_id"].'" class="option_title">'.$row["option_title"].'</div>
        		    <div>
        		      <input type="radio" name="options" id="option1" value="'.$row["option_title"].'" '.$is_correct.'>
        		      <button type="button" data-option-id = "'.$row["option_id"].'" class="btn btn-sm delete_option"><i class="fas fa-times"></i></button>
        		    </div>
        		</li>
			';	
		}

		$data2 = array(
			'question'		=> $question,
			'options'		=> $options
		);

		echo json_encode($data2);
	}

	if($_POST["action"] == 'delete_question') 
	{
		$object->query = "DELETE FROM questions WHERE question_id = '".$_POST["question_id"]."'";

		$object->execute();

		$object->query = "SELECT * FROM questions WHERE quiz_id = '".$_SESSION["quiz_id"]."'";

		$result = $object->get_result();

		$data = '';

		foreach($result as $row) 
		{
			$data .= '
				<li class="nav-item py-2 border-bottom d-flex justify-content-between">
				<div class="question_title">'.$row["question"].'</div>
				<div>
				  <button type="button" id="edit_option" data-question-id = "'.$row["question_id"].'" class="btn btn-sm edit_question"><i class="fas fa-edit"></i></button>
				  <button type="button" id="delete_option" data-question-id = "'.$row["question_id"].'" class="btn btn-sm delete_question"><i class="fas fa-times"></i></button>
				</div>
				</li>
			';
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'delete_option') 
	{
		$object->query = "DELETE FROM options WHERE option_id = '".$_POST["option_id"]."'";

		$object->execute();

		$object->query = "SELECT * FROM questions WHERE question_id = '".$_SESSION["question_id"]."'";

		$result = $object->get_result();

		$correct_option = '';

		foreach($result as $row) 
		{
			$correct_option = $row["correct_option"];	
		}

		$object->query = "SELECT * FROM options WHERE question_id = '".$_SESSION["question_id"]."'";

		$result = $object->get_result();

		$options = '';

		foreach($result as $row) 
		{
			$is_correct = '';

			if($correct_option == $row["option_title"]) 
			{
				$is_correct = 'checked';
			}
			$options .= '
				<li class="nav-item py-2 border-bottom d-flex justify-content-between">
        		    <div contenteditable="true" data-option-id = "'.$row["option_id"].'" class="option_title">'.$row["option_title"].'</div>
        		    <div>
        		      <input type="radio" name="options" id="option1" value="'.$row["option_title"].'" '.$is_correct.'>
        		      <button type="button" data-option-id = "'.$row["option_id"].'" class="btn btn-sm delete_option"><i class="fas fa-times"></i></button>
        		    </div>
        		</li>
			';	
		}

		echo json_encode($options);
	}

	if($_POST["action"] == 'fetch_quiz') 
	{
		$_SESSION["quiz_id"] = $_POST["quiz_id"];

		$quiz_title = '';

		$quiz_duration = '';

		$time_unit = '';

		$passing_percentage = '';

		$object->query = "SELECT * FROM quizes WHERE quiz_id = '".$_POST["quiz_id"]."'";

		$result = $object->get_result();

		foreach($result as $row) 
		{
			$quiz_title = $row["quiz_title"];
			$quiz_duration = $row["quiz_duration"];
			$time_unit = '1';
			if($quiz_duration >= 60) {
				$quiz_duration = $quiz_duration/60;
				$time_unit = '60';
			}
			$passing_percentage = $row["passing_percentage"];
		}

		$object->query = "SELECT * FROM questions WHERE quiz_id = '".$_POST["quiz_id"]."'";

		$result2 = $object->get_result();

		$data2 = '';

		foreach($result2 as $row2) 
		{
			$data2 .= '
				<li class="nav-item py-2 border-bottom d-flex justify-content-between">
				<div class="question_title">'.$row2["question"].'</div>
				<div>
				  <button type="button" id="edit_option" data-question-id = "'.$row2["question_id"].'" class="btn btn-sm edit_question"><i class="fas fa-edit"></i></button>
				  <button type="button" id="delete_option" data-question-id = "'.$row2["question_id"].'" class="btn btn-sm delete_question"><i class="fas fa-times"></i></button>
				</div>
				</li>
			';
		}

		$data3 = array(
			'quiz_title'			=> $quiz_title,
			'questions'				=> $data2,
			'quiz_duration'			=> $quiz_duration,
			'time_unit'				=> $time_unit,
			'passing_percentage'	=> $passing_percentage
		);

		echo json_encode($data3);
	}

	if($_POST["action"] == 'update_quiz')
	{
		$data = array(
			':quiz_duration'		=> $_POST["quiz_duration"],
			':passing_percentage'	=> $_POST["passing_percentage"],
			':quiz_id'				=> $_SESSION["quiz_id"]
		);

		$object->query = "
		UPDATE quizes SET 
		quiz_duration = :quiz_duration, 
		passing_percentage = :passing_percentage 
		WHERE quiz_id = :quiz_id";

		$object->execute($data);
	}

    if($_POST["action"] == 'delete_topic')
	{

		$object->query = "
		DELETE FROM topics 
		WHERE topic_id = '".$_POST["topic_id"]."'
		";

		$object->execute();

		echo json_encode($object->material_fetch($_SESSION["course_id"]));
	}

	if($_POST["action"] == 'delete_material')
	{

		$object->query = "
		DELETE FROM materials 
		WHERE material_id = '".$_POST["material_id"]."'
		";

		$object->execute();

		$object->query = "
		SELECT * FROM materials 
		WHERE material_id = '".$_POST["material_id"]."'";

		$result = $object->get_result();

		foreach($result as $row) 
		{
			unlink($row["material_link"]);
		}

		$object->query = "
		SELECT * FROM materials 
		WHERE topic_id = '".$_POST["topic_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$icon = '';

			if($row["material_type"] == 'YouTube Video' || $row["material_type"] == 'Video Lesson') 
			{
				$icon = '<i class="fa-brands fa-youtube me-2"></i>';
			}
			else
			{
				$icon = '<i class="fa-solid fa-file-powerpoint me-2"></i>';
			}

			$data[] = '
				<li class="nav-item py-2 border-bottom">
					<div class="d-flex justify-content-between align-items-center">
					  <div>'.$icon.' '.$row["material_name"].'</div>
					  <div class="div">
						<button type="button" name="edit_button" data-material-id="'.$row["material_id"].'" data-topic-id="'.$row["topic_id"].'" id="edit_button" class="btn btn-outline-primary btn-circle btn-sm edit_material"><i class="fas fa-edit"></i></button>
						&nbsp;
						<button type="button" name="delete_button" data-material-id="'.$row["material_id"].'" data-topic-id="'.$row["topic_id"].'" id="delete_button" class="btn btn-outline-danger btn-circle btn-sm delete_material"><i class="fas fa-times"></i></button>
					  </div>
					</div>
				</li>
			';
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'delete_quiz')
	{

		$object->query = "
		DELETE FROM quizes 
		WHERE quiz_id = '".$_POST["quiz_id"]."'
		";

		$object->execute();

		$object->query = "SELECT * FROM quizes WHERE topic_id = '".$_POST["topic_id"]."'";
		
		$result = $object->get_result();

		$data2 = '';

		foreach($result as $row) 
		{
			$data2 .= '
			<li class="nav-item py-2 border-bottom">
			<div class="d-flex justify-content-between align-items-center">
			  <div>'.$row["quiz_title"].'</div>
			  <div class="div">
				<button type="button" name="edit_button" data-quiz-id="'.$row["quiz_id"].'" data-topic-id="'.$row["topic_id"].'" id="edit_quiz" class="btn btn-outline-primary btn-circle btn-sm edit_material"><i class="fas fa-edit"></i></button>
				&nbsp;
				<button type="button" name="delete_button" data-quiz-id="'.$row["quiz_id"].'" data-topic-id="'.$row["topic_id"].'" id="delete_quiz" class="btn btn-outline-danger btn-circle btn-sm delete_material"><i class="fas fa-times"></i></button>
			  </div>
			</div>
			</li>
			';
		}

		echo json_encode($data2);
	}

	if($_POST["action"] == 'change_status')
	{
		$data = array(
			':course_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE courses 
		SET course_status = :course_status 
		WHERE course_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Course Status change to '.$_POST['next_status'].'</div>';
	}

	if($_POST["action"] == 'upload_lesson')
	{
		if(isset($_FILES["file"])) 
		{
			$file_name =  $_FILES['file']['name'];
			$tmp_name = $_FILES['file']['tmp_name'];
			move_uploaded_file($tmp_name, "videos/".$file_name);
		}

		$duration = $_POST["duration"];

		$hour = floor($duration / 3600);
		$min = floor(($duration % 3600) / 60);
		$sec = round($duration % 60);

		$data = array(
			'duration'	=> $duration,
			'hour'		=> $hour,
			'min'		=> $min,
			'sec'		=> $sec,
			'file_name'	=> 'videos/'.$file_name
		);

		echo json_encode($data);
	}

	if($_POST["action"] == 'save_course')
	{
		$object->query = "SELECT * FROM courses WHERE course_id = '".$_SESSION["course_id"]."'";

		$result = $object->get_result();

		foreach($result as $row)
		{
			$course_photo = $row["course_photo"];
		}

		$file_name = $course_photo;

		if(isset($_FILES["imageFile"])) 
		{
			$file_name =  $_FILES['imageFile']['name'];
			$tmp_name = $_FILES['imageFile']['tmp_name'];
			move_uploaded_file($tmp_name, "img/".$file_name);
			$file_name = 'img/'.$file_name;
		}

		$data = array(
		  ':course_title'			=> $_POST["course_title"],
          ':course_info'			=> $_POST["course_info"],
          ':course_author'			=> $_POST["course_author"], 
          ':course_duration'		=> $_POST["course_duration"], 
          ':course_level'			=> $_POST["course_level"],
          ':course_learning'		=> $_POST["course_learning"], 
          ':course_material'		=> $_POST["course_material"], 
          ':course_requirements'	=> $_POST["course_requirements"],
		  ':featured_video'			=> $_POST["featured_video"],
		  ':course_certificate'		=> $_POST["course_certificate"],
		  ':course_photo'			=> $file_name,
		  ':course_id'				=> $_SESSION["course_id"]
		);

		$object->query = "
		UPDATE courses SET 
		course_title = :course_title,
		course_info = :course_info,
		course_author = :course_author,
		course_duration = :course_duration,
		course_level = :course_level,
		course_learning = :course_learning,
		course_materials = :course_material,
		course_photo = :course_photo,
		course_requirements = :course_requirements,
		course_certificate = :course_certificate,
		featured_video = :featured_video  
		WHERE course_id = :course_id
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Course Contents Saved!!</div>';
	}

	if($_POST["action"] == 'delete')
	{
		$object->query = "DELETE FROM courses WHERE course_id = '".$_POST["id"]."'";

		$object->execute();

		echo '<div class="alert alert-success">Course Deleted</div>';
	}

	if($_POST["action"] == 'delete_course')
	{
		$object->query = "DELETE FROM courses WHERE course_id = '".$_SESSION["course_id"]."'";

		$object->execute();
	}

	if($_POST["action"] == 'publish')
	{
		$object->query = "
		SELECT courses.* FROM courses 
		INNER JOIN (topics INNER JOIN materials ON topics.topic_id = materials.topic_id) 
		ON courses.course_id = topics.course_id 
		WHERE courses.course_id = '".$_SESSION["course_id"]."'";

		$object->execute();

		$publish = true;

		$submit = '';

		if($object->row_count() > 0)
		{
			if($_POST["admin_type"] == 'master')
			{
				$object->query = "
				UPDATE courses SET course_status = 'Publish' WHERE course_id = '".$_SESSION["course_id"]."';
				";
				$object->execute();
				$submit = 'Published';
			}
			else
			{
				$object->query = "
				UPDATE courses SET course_status = 'Pending' WHERE course_id = '".$_SESSION["course_id"]."';
				";
				$object->execute();
				$submit = 'Pending';
			}
		}
		else
		{
			$publish = false;
		}

		$output = array(
			'publish'	=> $publish,
			'submit2'	=> $submit
		);

		echo json_encode($output);
	}
}

function upload_image()
{
	if(isset($_FILES["course_image"]))
	{
		$extension = explode('.', $_FILES['course_image']['name']);
		$new_name = rand() . '.' . $extension[1];
		$destination = 'img/' . $new_name;
		move_uploaded_file($_FILES['course_image']['tmp_name'], $destination);
		return $destination;
	}
}
?>