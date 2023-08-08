<?php
include('main.php');
$object = new brbd();

if(isset($_POST["action"])) {

    if($_POST["action"] == 'fetch') {

        $order_column = array(
			1 => 'instructor_name', 
			2 => 'commission_rate', 
			3 => 'instructor_status'
		);

		$output = array();

		$main_query = "SELECT * FROM instructors ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE instructor_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR instructor_status LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR commission_rate LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY instructor_id DESC ';
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

			$object->query = "SELECT * FROM courses WHERE course_author = '".$row['instructor_id']."'";

			$object->execute();

            $sub_array = array();

			$sub_array[] = '<img src="'.$row["instructor_photo"].'" class="img-fluid img-thumbnail" width="75" height="75" />';

            $sub_array[] = html_entity_decode($row["instructor_name"]);

			$sub_array[] = $row["instructor_email"];

			$sub_array[] = $object->row_count();;

			$sub_array[] = $row["commission_rate"];

            $status = '';

			if($row["instructor_status"] == 'Approved')
			{
				$status = '<button type="button" name="status_button" class="btn btn-success btn-sm status_button" data-id="'.$row["instructor_id"].'" data-status="'.$row["instructor_status"].'">Approved</button>';
			}
			else
			{
				$status = '<button type="button" name="status_button" class="btn btn-warning btn-sm status_button" data-id="'.$row["instructor_id"].'" data-status="'.$row["instructor_status"].'">Pending</button>';
			}
			$sub_array[] = $status;
            $sub_array[] = '
			<div align="center">
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["instructor_id"].'"><i class="fas fa-edit"></i></button>
			&nbsp;
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["instructor_id"].'" data-status="'.$row["instructor_status"].'"><i class="fas fa-times"></i></button>
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

    if($_POST["action"] == 'Add')
	{
		$error = '';

		$success = '';

		$data = array(
			':instructor_email'	=>	$_POST["instructor_email"]
		);

		$object->query = "
		SELECT * FROM instructors 
		WHERE instructor_email = :instructor_email
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Instructor Email Already Exists</div>';
		}
		else
		{
			$instructor_image = '';
			if($_FILES["instructor_image"]["name"] != '')
			{
				$instructor_image = upload_image();
			}

			$data = array(
				':instructor_name'			=>	$_POST["instructor_name"],
				':instructor_email'			=>	$_POST["instructor_email"],
				':instructor_commission'	=>	$_POST["instructor_commission"],
				':instructor_profile'		=>	$instructor_image,
				':instructor_status'		=>	'Pending'
			);

			$object->query = "
			INSERT INTO instructors 
			(instructor_name, instructor_email, commission_rate, instructor_photo, instructor_status) 
			VALUES (:instructor_name, :instructor_email, :instructor_commission, :instructor_profile, :instructor_status)
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Instructor Added</div>';
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

    if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM instructors 
		WHERE instructor_id = '".$_POST["instructor_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['instructor_name'] = $row['instructor_name'];
			$data['instructor_email'] = $row['instructor_email'];
			$data['instructor_commission'] = $row['commission_rate'];
			$data['instructor_profile'] = $row['instructor_photo'];
		}

		echo json_encode($data);
	}

    if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':instructor_email'		=>	$_POST["instructor_email"],
			':instructor_id'		=>	$_POST['hidden_id']
		);

		$object->query = "
		SELECT * FROM instructors 
		WHERE instructor_email = :instructor_email 
		AND instructor_id != :instructor_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Instructor Already Exists</div>';
		}
		else
		{

			$instructor_image = $_POST["hidden_instructor_image"];
			if($_FILES["instructor_image"]["name"] != '')
			{
				$instructor_image = upload_image();
			}

			$data = array(
				':instructor_name'			=>	$_POST["instructor_name"],
				':instructor_email'			=>	$_POST["instructor_email"],
				':instructor_commission'	=>	$_POST["instructor_commission"],
				':instructor_profile'		=>	$instructor_image
			);

			$object->query = "
			UPDATE instructors 
			SET instructor_name = :instructor_name,
			instructor_email = :instructor_email,
			commission_rate = :instructor_commission,
			instructor_photo = :instructor_profile
			WHERE instructor_id = '".$_POST['hidden_id']."'
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Instructor Updated</div>';
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

    if($_POST["action"] == 'change_status')
	{
		$data = array(
			':instructor_status'		=>	$_POST['next_status']
		);

		$object->query = "UPDATE instructors SET instructor_status = :instructor_status WHERE instructor_id = '".$_POST["id"]."'";

		$object->execute($data);

		echo '<div class="alert alert-success">Instructor Status change to '.$_POST['next_status'].'</div>';
	}

    if($_POST["action"] == 'delete')
	{
		$object->query = "SELECT * FROM instructors WHERE instructor_id = '".$_POST["id"]."'";

		$result = $object->get_result();

		$photo = '';

		foreach($result as $row) {
			$photo = $row["instructor_photo"];			
		}

		unlink($photo);

		$object->query = "
		DELETE FROM instructors 
		WHERE instructor_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Instructor Deleted</div>';
	}
}

function upload_image()
{
	if(isset($_FILES["instructor_image"]))
	{
		$extension = explode('.', $_FILES['instructor_image']['name']);
		$new_name = rand() . '.' . $extension[1];
		$destination = 'img/' . $new_name;
		move_uploaded_file($_FILES['instructor_image']['tmp_name'], $destination);
		return $destination;
	}
}
?>