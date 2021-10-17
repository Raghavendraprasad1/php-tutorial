 <?php

   $servername = "localhost";
	$username = "raghav3";
	$password = "Raghu@123";
	$dbname = "college";


	$conn = new mysqli($servername, $username, $password, $dbname);


	if ($conn->connect_error) {
  	  die("Connection failed: " . $conn->connect_error);
		}


	?>