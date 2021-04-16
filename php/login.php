<?php
session_start();

include 'db_connection.php';


$query = "SELECT Count(*) as c from customers where Emailid=? AND Password=?";

if(isset($_POST['user_login']))
{

		$email = $_POST['email'];
		$password = $_POST['password'];

		$connection = OpenCon();

		if($stmt = $connection->prepare($query)) {

			$stmt->bind_param("ss",$email,$password);
			$stmt->bind_result($row);
			$stmt->execute();
			$stmt->store_result();
			$stmt->fetch();

			if($row) 
			{	
				$_SESSION['email'] = $email;
				$_SESSION['pass'] = $password;
				Print '<script>window.location.assign("http://localhost:8080/lenskart/home.php");</script>';			
			}
			else
			{	
				Print '<script>alert("Incorrect EmailID or Password!");</script>';
       	    	Print '<script>window.location.assign("http://localhost:8080/lenskart/index.html");</script>';
			}
		}
		else{
			echo "Error".$connection->error;
		}
		CloseCon($connection);
}

if(isset($_POST['admin_login'])) {

	$admin_id = $_POST['uid'];
	$pass = $_POST['pass'];

	if($admin_id == "suraj123" and $pass = "abc") {
		echo "<script>
				window.location.href='http://localhost:8080/lenskart/admin.php';
			</script>";

	}else{
		echo "<script>
				alert('Invalid Admin UID');
				window.location.href='http://localhost:8080/lenskart/admin_login.php';
			</script>";
	}
}

?>