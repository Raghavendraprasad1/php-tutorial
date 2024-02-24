<?php
require '../db_config.php';

$post = file_get_contents('php://input');
$post = json_decode($post);

$searchVal = $post->searchVal;
if(!empty($searchVal))
{
    $sql = "SELECT * FROM posts WHERE title like '%$searchVal%' OR description like '%$searchVal%' ";
}
else{

    $sql = "SELECT * FROM posts";
}
$result = $conn->query($sql);

if (!empty($result)) {
    while ($row = $result->fetch_assoc()) {
        $json[] = $row;
    }

    $data['data'] = $json;
    // $result =  mysqli_query($mysqli, $sql);
    echo json_encode($data);
}
