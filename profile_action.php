<?php
include('admin/main.php');
$object = new brbd();

if(isset($_POST["action"]))
{
    if($_POST["action"] == 'update_profile')
    {
        $message = '';

        $student_photo = $_POST["hidden_student_photo"];
		if($_FILES["student_photo"]["name"] != '') 
		{
			$student_photo =  $_FILES['student_photo']['name'];
			$tmp_name = $_FILES['student_photo']['tmp_name'];
			move_uploaded_file($tmp_name, "img/".$student_photo);
			$student_photo = 'img/'.$student_photo;
		}

        $data = array(
            ':student_first_name' => $_POST["student_first_name"],
            ':student_last_name' => $_POST["student_last_name"],
            ':student_user_name' => $_POST["student_user_name"],
            ':student_mobile' => $_POST["student_mobile"],
            ':student_skill' => $_POST["student_skill"],
            ':student_biography' => $_POST["student_biography"],
            ':student_photo'    => $student_photo
        );

        $object->query = "
        UPDATE students SET 
        student_first_name = :student_first_name,
        student_last_name = :student_last_name,
        student_user_name = :student_user_name,
        student_mobile = :student_mobile,
        student_skill = :student_skill,
        student_biography = :student_biography,
        student_photo = :student_photo WHERE student_id = '".$_SESSION["user_id2"]."'
        ";

        $object->execute($data);

        $message = '<div class="alert alert-success">User Details Updated</div>';

        $output = array(
            'student_first_name' => $_POST["student_first_name"],
            'student_last_name' => $_POST["student_last_name"],
            'student_user_name' => $_POST["student_user_name"],
            'student_mobile' => $_POST["student_mobile"],
            'student_skill' => $_POST["student_skill"],
            'student_biography' => $_POST["student_biography"],
            'student_photo' => $student_photo,
            'message'   => $message
        );

        echo json_encode($output);
    }

    if($_POST["action"] == 'change_password')
    {
        $message = '';

        $object->query = "SELECT * FROM students WHERE student_id = '".$_SESSION["user_id2"]."'";

        $result = $object->get_result();

        foreach($result as $row)
        {
            if($row["student_password"] == $_POST["current_password"])
            {
                if($_POST["new_password"] == $_POST["retype_password"])
                {
                    $object->query = "
                    UPDATE students SET
                    student_password = '".$_POST["new_password"]."'
                    WHERE student_id = '".$_SESSION["user_id2"]."'
                    ";
    
                    $object->execute();
    
                    $message = '<div class="alert alert-success">Password Changed Successfully!!</div>';
                }
                else
                {
                    $message = '<div class="alert alert-danger">Retyped Password does not match!!</div>';
                }
            }
            else
            {
                $message = '<div class="alert alert-danger">Current password does not match!!</div>';
            }
        }

        echo json_encode($message);
    }
}
?>
