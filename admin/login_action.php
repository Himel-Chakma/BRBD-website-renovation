<?php
include('main.php');
$object = new brbd();

if(isset($_POST["username"]))
{
	$error = '';

	$data = array(
		':username'	=>	$_POST["username"]
	);

	$object->query = "
		SELECT * FROM users 
		WHERE user_name = :username
	";

	$object->execute($data);

	$total_row = $object->row_count();

	if($total_row == 0)
	{
		$error = '<div class="alert alert-danger">Wrong Username</div>';
	}
	else
	{

		$result = $object->statement_result();

		foreach($result as $row)
		{

			if($_POST['passcode'] == $row["user_password"])
			{
				$_SESSION['user_id'] = $row['user_id'];
			}
			else
			{
				$error = '<div class="alert alert-danger">Wrong Password</div>';
			}
			
		}
	}

	$output = array(
		'error'		=>	$error
	);

	echo json_encode($output);
}

?>