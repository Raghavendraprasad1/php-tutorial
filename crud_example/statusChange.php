<?php
session_start();
include('db_config.php');

$value=$_GET['v'];
$id= base64_decode($_GET['id']);
$sql="UPDATE customer SET status=$value where id=$id";

$result = $conn->query($sql);

if($result)
{
	$_SESSION['success'] = 'status changed successfully.';
	header("Location: ./index.php");
}

?>