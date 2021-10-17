<?php
session_start();
include('db_config.php');
$action = $_GET['action'];

if ($action == 'edit') {
	$btn_name = "Update";
} else {
	$btn_name = "Save";
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	<title>Add Data</title>
</head>

<body>
	<?php

	$id = $firstname = $lastname = $phone = $email =  $password = '';

	if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'edit') {
		$id = base64_decode($_GET['id']);

		$sql = "select * from customer where id= $id";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {

			$record = $result->fetch_assoc();

			$firstname = $record['firstname'];
			$lastname = $record['lastname'];
			$phone = $record['phone'];
			$email = $record['email'];
			$password = $record['password'];
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}


	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// get form post data after submit and update  -->
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$id = $_POST['id'];

		if (isset($_FILES['image'])) {
			$errors = array();
			$file_name = $_FILES['image']['name'];
			$file_size = $_FILES['image']['size'];
			$file_tmp = $_FILES['image']['tmp_name']; // this variable is used to store the data into folder physically
			$file_type = $_FILES['image']['type'];

			// get extension of image file
			$extarr = explode('.', $file_name);
			$file_ext = $extarr[count($extarr) - 1];
			$extensions = array("jpeg", "jpg", "png");

			// check type of image of file
			if (in_array($file_ext, $extensions) === false) {
				$errors[] = "extension not allowed, please choose a JPEG or PNG file.";
			}

			if ($file_size > 2097152) {
				$errors[] = 'File size must be excately 2 MB';
			}

			if (empty($errors) == true) {
				// code to upload file into directory
				move_uploaded_file($file_tmp, "./images/" . $file_name);
			} else {
				$_SESSION['error'] = 'Error while uploading image.';
				header("Location: ./index.php");
			}
		}
		// Code to Add new record into database -->
		if (empty($_POST['id'])) {
			
			$sql = "INSERT INTO customer (firstname, lastname,phone,image,email,password)
					VALUES ('$firstname','$lastname',$phone,'$file_name','$email','$password')";

			if ($conn->query($sql) === TRUE) {
				$_SESSION['success'] = 'New record created successfully.';
				header("Location: ./index.php");
			} else {
				$_SESSION['success'] = 'Error while creating new record.';
				header("Location: ./index.php");
			}
		} else if ($_POST['id']) {
			// code to update data into database -->
			$sql = "UPDATE customer SET 
     		firstname = '$firstname',
     		lastname = '$lastname',
     		phone = '$phone',
     		email =  '$email',
     		image = '$file_name'

     		WHERE id= $id";

			if ($conn->query($sql) === TRUE) {
				$_SESSION['success'] = 'record updated successfully.';
				header("Location: ./index.php");
			} else {
				$_SESSION['error'] = 'Error while updating the record.';
				header("Location: ./image_gallary.php");
			}
		}
	}
	?>

	<!-- Add/Update form Start  -->
	<form action="" method="POST" style="margin-left: 27rem;" enctype="multipart/form-data">
		<div class="card pt-2" style="max-width: 28rem; background-color: lightgray;">
			<div class="card-header">
				<header style="text-align: center;">
					<h2>Add/Update Customer</h2>
				</header>
			</div>
			<div class="card-body">
				<input type="hidden" name="id" value="<?= $id ?>">
				<div class="card-text mb-2">
					First Name: <input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?= $firstname ?>">
				</div>
				<div class="card-text mb-2">
					Last Name: <input type="text" name="lastname" class="form-control" placeholder="Last Name" value="<?= $lastname ?>">
				</div>
				<div class="card-text mb-2">
					Phone: <input type="text" name="phone" class="form-control" placeholder="Please enter your phone" value="<?= $phone ?>">
				</div>
				<div class="card-text mb-2">
					Image: <input type="file" name="image" class="form-control" accept="image/*">
				</div>
				<div class="card-text mb-2">
					Email: <input type="text" name="email" class="form-control" placeholder="Please enter your Email" value="<?= $email ?>">
				</div>
				<div class="card-text mb-2">
					Password: <input type="password" name="password" class="form-control" placeholder="Please enter your password" value="<?= $password ?>">
				</div>
			</div>
			<div class="card-footer mb-2">
				<a class="btn btn-primary" href="./index.php">Back</a>
				<input class="btn btn-success" type="submit" name="submit" value="<?= $btn_name ?>">
			</div>
		</div>
	</form>

</body>

</html>