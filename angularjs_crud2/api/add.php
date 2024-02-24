<?php
require '../db_config.php';

$post = file_get_contents('php://input');
$post = json_decode($post);

$sql = "INSERT into posts(title, description) VALUES('$post->title', '$post->description')";
  
 $insert_result = $conn->query($sql);
 if($insert_result)
 {
      $select_sql = "SELECT * from posts order by id desc LIMIT 1";
      $result = $conn->query($select_sql);
      $data = $result->fetch_assoc();

      echo json_encode($data);
 }
