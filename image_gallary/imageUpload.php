<?php

session_start();
require('db_config.php');

if(isset($_POST) && !empty($_FILES['image']['name']) && !empty($_POST['title'])){

	$name = $_FILES['image']['name'];
	list($txt, $ext) = explode(".", $name);
	$image_name = time().".".$ext;
	$tmp = $_FILES['image']['tmp_name']; // used to upload image in folder


	if(move_uploaded_file($tmp, 'uploads/'.$image_name)){

		$sql = "INSERT INTO image_gallery (title, image) VALUES ('".$_POST['title']."', '".$image_name."')";

		$result = $conn->query($sql);

        if($result)
        {
        	$_SESSION['success'] = 'Image Uploaded successfully.';
		    header("Location: ./image_gallary.php"); // used for redirection

        }
        else{
        	$_SESSION['error'] = 'image uploading failed';
		    header("Location: ./image_gallary.php");
        }
	}else{
		$_SESSION['error'] = 'image uploading failed';
		header("Location: ./image_gallary.php");
	}
}else{
	$_SESSION['error'] = 'Please Select Image or Write title';
	header("Location: ./image_gallary.php");
}

?>