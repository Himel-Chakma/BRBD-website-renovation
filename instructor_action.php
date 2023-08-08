<?php
include('admin/main.php');
$object = new brbd();
if(isset($_POST["action"]))
{
    if($_POST["action"] == 'instructor_request')
    {
        $object->query = "SELECT * FROM students WHERE student_id = '".$_POST["student_id"]."'";

        $result = $object->get_result();

        $instructor_name = '';
        $instructor_email = '';
        $instructor_photo = '';

        foreach($result as $row)
        {
            $instructor_name  = $row["student_first_name"].$row["student_last_name"];
            $instructor_email = $row["student_email"];
            $instructor_photo = $row["student_photo"];
        }

        $data = array(
            ':instructor_name'      => $instructor_name,
            ':instructor_email'     => $instructor_email,
            ':instructor_photo'     => $instructor_photo,
            ':commission_rate'      => 80,
            ':instructor_status'    => 'Pending',
            ':student_id'           => $_POST["student_id"],
        );

        $object->query = "
        INSERT INTO instructors(instructor_name, instructor_email, instructor_photo, commission_rate, instructor_status, student_id)VALUES
        (:instructor_name, :instructor_email, :instructor_photo, :commission_rate, :instructor_status, :student_id);
        ";

        $object->execute($data);

        $last_insert_id = $object->last_insert_id();

        $object->query = "SELECT * FROM instructors WHERE instructor_id = '$last_insert_id'";

        $result = $object->get_result();

        $request_on = '';

        foreach($result as $row)
        {
            $request_on = $row["request_on"];
            $date = new DateTime($request_on);
            $request_on = $date->format('d F Y');
        }

        echo json_encode($request_on);
    }

    if($_POST["action"] == 'delete_course')
	{
		$object->query = "DELETE FROM courses WHERE course_id = '".$_POST["course_id"]."'";

		$object->execute();
	}
}
?>