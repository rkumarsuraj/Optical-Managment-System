<?php
session_start();

include 'db_connection.php';

$connection = OpenCon();

if(isset($_POST['add_glass'])) {

	#$code = $_POST['code'];
	$type = $_POST['type'];
	$brand = $_POST['brand'];
	$price = $_POST['price'];

	$query = "INSERT INTO glasses(GlassType,GlassBrand,Price) Values(?,?,?)";

	if($stmt = $connection->prepare($query)) {

		$stmt->bind_param("ssi",$type,$brand,$price);
		if($stmt->execute()){
			echo "<script>
					alert('Product Added');
					window.location.href='http://localhost:8080/lenskart/admin.php';
				</script>";
		}
		else{
			echo "<script>
					alert('Product Already Present');
					window.location.href='http://localhost:8080/lenskart/admin.php';
				</script>";
		}

		
	}
	else{
		echo $connection->error;
	}
}

if(isset($_POST['delete_glass'])) {

	$code = $_POST['code'];

	$query = "DELETE From Glasses where GlassCode = ?";

	if($stmt = $connection->prepare($query)) {

		$stmt->bind_param("i",$code);
		$stmt->execute();
		if($stmt->affected_rows){

			echo "<script>
					alert('Product Deleted');
					window.location.href='http://localhost:8080/lenskart/admin.php';
				</script>";
				
		}
		else{

			echo "<script>
					alert('Product Not Present');
					window.location.href='http://localhost:8080/lenskart/admin.php';
				</script>";
			
		}

	}
	else{
		echo $connection->error;
	}
}


if(isset($_POST['add_frame'])) {

	#$code = $_POST['code'];
	$type = $_POST['type'];
	$brand = $_POST['brand'];
	$price = $_POST['price'];

	$query = "INSERT INTO frames(FrameType,FrameBrand,Price) Values(?,?,?)";

	if($stmt = $connection->prepare($query)) {

		$stmt->bind_param("ssi",$type,$brand,$price);
		if($stmt->execute()){
			echo "<script>
					alert('Product Added');
					window.location.href='http://localhost:8080/lenskart/admin.php';
				</script>";
		}
		else{
			echo "<script>
					alert('Product Already Present');
					window.location.href='http://localhost:8080/lenskart/admin.php';
				</script>";
		}

		
	}
	else{
		echo $connection->error;
	}
}

if(isset($_POST['delete_frame'])) {

	$code = $_POST['code'];

	$query = "DELETE From Frames where FrameCode = ?";

	if($stmt = $connection->prepare($query)) {

		$stmt->bind_param("i",$code);
		$stmt->execute();
		if($stmt->affected_rows){

			echo "<script>
					alert('Product Deleted');
					window.location.href='http://localhost:8080/lenskart/admin.php';
				</script>";
				
		}
		else{

			echo "<script>
					alert('Product Not Present');
					window.location.href='http://localhost:8080/lenskart/admin.php';
				</script>";
			
		}

	}
	else{
		echo $connection->error;
	}
}

if(isset($_POST['update_glass'])) {

	$code = $_POST['code'];
	$type = $_POST['type'];
	$brand = $_POST['brand'];
	$price = $_POST['price'];

	$query = "UPDATE Glasses SET GlassType = ?, GlassBrand = ?, Price =? WHERE glasscode = ?";

	if($stmt = $connection->prepare($query)){
		$stmt->bind_param("ssii",$type,$brand,$price,$code);
		if($stmt->execute()){
			echo "<script>
					alert('Product Updated');
					window.location.href='http://localhost:8080/lenskart/admin.php';
				</script>";
		}
		else
			echo $stmt->error;
	}
	else
		echo $connection->error;
}

CloseCon($connection);

session_destroy();
?>
