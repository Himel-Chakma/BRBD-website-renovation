<?php
include('admin/main.php');
$object = new brbd();

if(isset($_POST["action"]))
{
    if($_POST["action"] == 'Register')
    {
        $error = '';

        $data = array(
            ':first_name'   => $_POST["first_name"],
            ':last_name'    => $_POST["last_name"],
            ':username'     => $_POST["username"],
            ':user_email'   => $_POST["user_email"],
            ':user_password'=> $_POST["user_password"],
            ':user_photo'   => $object->make_avatar($_POST["username"][0])
        );

        $data2 = array(
            ':user_email'	=>	$_POST["user_email"]
        );
    
        $object->query = "
            SELECT * FROM students 
            WHERE student_email = :user_email
        ";
    
        $object->execute($data2);
    
        $total_row = $object->row_count();
    
        if($total_row > 0)
        {
            $error = '<div class="alert alert-danger">Email already exists!</div>';
        }
        else
        {
            if($_POST["user_password"] == $_POST["user_pass_conf"])
            {
                $object->query = "INSERT INTO students(student_first_name, student_last_name, student_user_name, student_email, student_password, student_photo)VALUES(:first_name, :last_name, :username, :user_email, :user_password, :user_photo)";
    
                $object->execute($data);
    
                $_SESSION["user_id2"] = $object->last_insert_id();
                
            }
            else
            {
                $error = '<div class="alert alert-danger">Password does not match</div>';
            }
        }

        $output = array(
            'error'		=>	$error
        );
    
        echo json_encode($output);
    }

    if($_POST["action"] == 'login')
    {
        $error = '';

        $data = array(
            ':useremail'	=>	$_POST["useremail"]
        );
    
        $object->query = "
            SELECT * FROM students 
            WHERE student_email = :useremail
        ";
    
        $object->execute($data);
    
        $total_row = $object->row_count();
    
        if($total_row == 0)
        {
            $error = '<div class="alert alert-danger">Wrong Email Address</div>';
        }
        else
        {
    
            $result = $object->statement_result();
    
            foreach($result as $row)
            {
    
                if($_POST['passcode'] == $row["student_password"])
                {
                    $_SESSION['user_id2'] = $row['student_id'];
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

    if($_POST["action"] == 'Send')
    {
        $error = '';

        $message = '';

        $password = '';

        $data = array(
            ':useremail'	=>	$_POST["useremail"]
        );
    
        $object->query = "
            SELECT * FROM students 
            WHERE student_email = :useremail
        ";
    
        $object->execute($data);
    
        $total_row = $object->row_count();
    
        if($total_row == 0)
        {
            $error = '<div class="alert alert-danger">Email does not exists!!</div>';
        }
        else
        {

            $object->query = "SELECT * FROM students WHERE student_email = :useremail";

            $object->execute($data);

            $result = $object->statement_result();

            foreach($result as $row)
            {
                $password = $row["student_password"];
            }

            require 'smtp/PHPMailerAutoload.php';
		    $mail = new PHPMailer();
		    $mail->IsSMTP();								//Sets Mailer to send message using SMTP
		    $mail->Host = 'smtp.gmail.com';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
		    $mail->Port = '587';								//Sets the default SMTP server port
		    $mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
		    $mail->Username = 'himelchakma55@gmail.com';					//Sets SMTP username
		    $mail->Password = 'pdlxbmtsflnszurz';					//Sets SMTP password
		    $mail->SMTPSecure = 'tls';							//Sets connection prefix. Options are "", "ssl" or "tls"
		    $mail->From = 'himelchakma55@gmail.com';					//Sets the From email address for the message
		    $mail->FromName = 'Be Researcher BD';				//Sets the From name of the message
		    $mail->AddAddress($_POST["useremail"]);		//Adds a "To" address
		    $mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
		    $mail->IsHTML(true);							//Sets message type to HTML				
		    $mail->Subject = 'Password Recovery';				//Sets the Subject of the message
		    $mail->Body = 'Your password is: '.$password;				//An HTML or plain text message body
		    if($mail->Send())								//Send an Email. Return true on success or false on error
		    {
		    	$message = '<div class="alert alert-success">Password is sent to your email!!</div>';
		    }
        }
        $data2 = array(
            'error'     => $error,
            'message'   => $message
        );

        echo json_encode($data2);
    }
}

?>