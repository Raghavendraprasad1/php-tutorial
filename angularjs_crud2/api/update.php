<?php
require '../db_config.php';

$id  = $_GET["id"];

$post = file_get_contents('php://input');
$post = json_decode($post);
$sql = "UPDATE posts SET title = '".$post->title."', description = '".$post->description."' WHERE id = '".$id."'";
$result = $conn->query($sql);

if($result)
{
$sql = "SELECT * FROM posts WHERE id = '".$id."'"; 
$result = $conn->query($sql);
$data = $result->fetch_assoc();
echo json_encode($data);
}
?>