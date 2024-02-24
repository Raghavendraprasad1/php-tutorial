<?php
require '../db_config.php';
$id  = $_GET["id"];
$sql = "DELETE FROM posts WHERE id = '".$id."'";
$result = $conn->query($sql);

echo json_encode([$id]);
?>