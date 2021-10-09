<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

	<title>Registration</title>
	<style type="text/css">
		.error {
			font-size: 15px;
			color: red;
		}
	</style>
</head>

<body>
	<?php

	$firstnameErr = $lastnameErr  = $phoneErr = $emailErr  = NULL;
	$firstname = $lastname  = $phone = $email  = NULL;

	$flag = true;
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if (empty($_POST["firstname"])) {
			$firstnameErr = "First name is required";
			$flag = false;
		} else {
			$firstname = test_input($_POST["firstname"]);
		}

		if (empty($_POST["lastname"])) {
			$lastnameErr = "Last name is required";
			$flag = false;
		} else {
			$lastname = test_input($_POST["lastname"]);
		}

		if (empty($_POST["phone"])) {
			$phoneErr = "Phone is required";
			$flag = false;
		} else {
			$phone = test_input($_POST["phone"]);
		}

		if (empty($_POST["email"])) {
			$emailErr = "Email is required";
			$flag = false;
		} else {
			$email = test_input($_POST["email"]);
		}

		$country = $_POST["country"];
		$state = $_POST["state"];

		// submit form if validated successfully
		if ($flag) {

			$conn = new mysqli('localhost', "raghav", "Raghu@123", "college");

			if ($conn->connect_error) {
				die("connection failed error: " . $conn->connect_error);
			}
			
			$sql = "INSERT INTO student (firstname,lastname,phone, email, country, state) VALUES('$firstname', '$lastname', '$phone', '$email', '$country', '$state') ";

		

			// execute sql insert
			if ($conn->query($sql) === TRUE) {
				echo "<script> alert('data saved successfully');</script>";
			}
		}
	}

	function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	?>
	<form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
		<div class="card pt-2 mx-auto" style="max-width: 30rem;">
			<div class="card-header" style="font-size: 25px;
			font-style: italic;">
				<header>Registration Form</header>
			</div>
			<div class="card-body">
				<div class="card-text mb-2">
					First Name* : <input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?= $firstname; ?>">
					<span class="error"> <?= $firstnameErr; ?></span>
				</div>
				<div class="card-text mb-2">
					Last Name* : <input type="text" name="lastname" class="form-control" placeholder="Last Name" value="<?= $lastname; ?>">
					<span class="error"> <?= $lastnameErr; ?></span>
				</div>
				<div class="card-text mb-2">
					Phone* : <input type="text" name="phone" class="form-control" placeholder="Please enter your phone" value="<?= $phone; ?>">
					<span class="error"> <?= $phoneErr; ?></span>
				</div>
				<div class="card-text mb-2">
					Email-id* : <input type="text" name="email" class="form-control" placeholder="Please enter your Email id" value="<?= $email; ?>">
					<span class="error"> <?= $emailErr; ?></span>
				</div>
				<div class="card-text mb-2">
					Country <small>(optional)</small> : <input type="text" name="country" class="form-control" placeholder="Please enter your Country" value="<?= $country; ?>">
				</div>
				<div class="card-text mb-2" style="background-size: 20px;">
					<label>State <small>(optional)</small>:</label> <select class="form-select" name="state" data-bs-toggle="dropdown">
						<option value=""> --select state-- </option>
						<option <?= $state == 'Delhi' ? 'selected' : '' ?> value="Delhi" >Delhi</option>
						<option <?= $state == 'Haryana' ? 'selected' : '' ?> value="Haryana" >Haryana</option>
						<option <?= $state == 'Punjab' ? 'selected' : '' ?> value="Punjab" >Punjab</option>
						<option <?= $state == 'Himachal Pradesh' ? 'selected' : '' ?> value="Himachal Pradesh" >Himachal Pradesh</option>
					</select>
				</div>
			</div>
			<div class="card-footer mb-2 btn-lg">
				<input class="button btn btn-primary" type="submit" name="button">
			</div>
		</div>
	</form>

</body>

</html>