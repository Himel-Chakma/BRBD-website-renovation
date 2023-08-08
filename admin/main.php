<?php
class brbd {
    public $conn;
    public $query;
    public $statement;
    
    function __construct() {
        $this->conn = new PDO("mysql:host=localhost;dbname=brbd;charset=utf8", "root", "");
        session_start();
    }
    
    function execute($data = null)
	{
		$this->statement = $this->conn->prepare($this->query);
		if($data)
		{
			$this->statement->execute($data);
		}
		else
		{
			$this->statement->execute();
		}		
	}

    function row_count()
	{
		return $this->statement->rowCount();
	}

    function last_insert_id() 
    {
        return $this->conn->lastInsertId();
    }

    function statement_result()
	{
		return $this->statement->fetchAll();
	}

    function get_result()
	{
		return $this->conn->query($this->query, PDO::FETCH_ASSOC);
	}

    function is_login()
	{
		if(isset($_SESSION['user_id']))
		{
			return true;
		}
		return false;
	}

    function clean_input($string)
	{
	  	$string = trim($string);
	  	$string = stripslashes($string);
	  	$string = htmlspecialchars($string);
	  	return $string;
	}
    function clean_output($array) {
        $string = $array;
		$string = implode(', ', $array);
		$string_with_spaces = str_replace(',', ', ', $string);
        return $string_with_spaces;
    }

	function material_fetch($course_id) 
	{
		$this->query = "
		SELECT * FROM topics 
		WHERE course_id = '".$course_id."' ORDER BY topic_serial ASC
		";
	
		$result = $this->get_result();
	
		$data2 = '';
	
		foreach($result as $row)
		{
			$this->query = "SELECT * FROM materials WHERE topic_id = '".$row["topic_id"]."'";
		
			$result2 = $this->get_result();

			$this->query = "SELECT * FROM quizes WHERE topic_id = '".$row["topic_id"]."'";
		
			$result3 = $this->get_result();
		
			$data2 .= '
			<li data-id = "'.$row["topic_id"].'" class = "list_items">
		  	<div class="card mb-3">
				<div class="card-header py-2 accordion">
				  <div class="row">
					  <div class="col d-flex align-items-center">
						  <h6 class="m-0 font-weight-bold text-primary"><i class="fa-solid fa-bars mr-2"></i> '.$row["topic_name"].'</h6>
					  </div>
					  <div clas="col" align="right">
						  <button type="button" name="edit_topic" id="edit_topic" data-topic-id="'.$row["topic_id"].'" class="btn btn-primary btn-circle btn-sm edit_topic"><i class="fas fa-edit"></i></button>
						  &nbsp;&nbsp;
						  <button type="button" name="delete_topic" id="delete_topic" data-topic-id="'.$row["topic_id"].'" class="btn btn-danger btn-circle btn-sm delete_topic"><i class="fas fa-times"></i></button>
					  </div>
				  </div>
				</div>
				<div class="card-body acc-panel">
				  <ul class="nav flex-column" id="topic'.$row["topic_id"].'">
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
					$data2 .= '
					<li class="nav-item py-2 border-bottom">
					<div class="d-flex justify-content-between align-items-center">
					  <div>'.$icon.' '.$row2["material_name"].'</div>
					  <div class="div">
						<button type="button" name="edit_button" data-material-id="'.$row2["material_id"].'" data-topic-id="'.$row["topic_id"].'" id="edit_material" class="btn btn-outline-primary btn-circle btn-sm edit_material"><i class="fas fa-edit"></i></button>
						&nbsp;
						<button type="button" name="delete_button" data-material-id="'.$row2["material_id"].'" data-topic-id="'.$row["topic_id"].'" id="delete_material" class="btn btn-outline-danger btn-circle btn-sm delete_material"><i class="fas fa-times"></i></button>
					  </div>
					</div>
					</li>
					';
				  }
				
				  $data2 .= '</ul>
				  <ul class="nav flex-column mb-3" id="quiz_container'.$row["topic_id"].'">
				  ';

				  foreach($result3 as $row3) {
					$data2 .= '
					<li class="nav-item py-2 border-bottom">
					<div class="d-flex justify-content-between align-items-center">
					  <div><i class="fa-regular fa-circle-question me-2"></i> '.$row3["quiz_title"].'</div>
					  <div class="div">
						<button type="button" name="edit_button" data-quiz-id="'.$row3["quiz_id"].'" data-topic-id="'.$row["topic_id"].'" id="edit_quiz" class="btn btn-outline-primary btn-circle btn-sm edit_quiz"><i class="fas fa-edit"></i></button>
						&nbsp;
						<button type="button" name="delete_button" data-quiz-id="'.$row3["quiz_id"].'" data-topic-id="'.$row["topic_id"].'" id="delete_quiz" class="btn btn-outline-danger btn-circle btn-sm delete_quiz"><i class="fas fa-times"></i></button>
					  </div>
					</div>
					</li>
					';
				  }

				  $data2 .= '</ul>
				  <button type="button" name="add_lesson" data-topic-id="'.$row["topic_id"].'" id="add_lesson" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus mr-2"></i> Add Lesson</button>
				  &nbsp;&nbsp;
				  <button type="button" name="add_quiz" data-topic-id="'.$row["topic_id"].'" id="add_quiz" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus mr-2"></i> Add Quiz</button>
				</div>
		  	</div>
			</li>
			';
		}
	
		return $data2;
	}

	function generateRandomString($length = 16) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		$charactersLength = strlen($characters);
	
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
	
		return $randomString;
	}
	
	function make_avatar($character)
	{
	    $path = "img/". time() . ".png";
		$image = imagecreate(200, 200);
		$red = rand(0, 255);
		$green = rand(0, 255);
		$blue = rand(0, 255);
	    imagecolorallocate($image, $red, $green, $blue);  
	    $textcolor = imagecolorallocate($image, 255, 255, 255);
	    imagettftext($image, 100, 0, 55, 150, $textcolor, 'arial.ttf', $character);
	    imagepng($image, $path);
	    imagedestroy($image);
	    return $path;
	}

	function fetch_count($id, $type)
	{
		$this->query = "SELECT * FROM course_enrolled WHERE student_id = '$id' AND enrolled_status = '$type'";

        $this->execute();
                    
        $total = $this->row_count();

		return $total;
	}

}
?>
