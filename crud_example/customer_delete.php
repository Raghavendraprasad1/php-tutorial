<?php
session_start();
include('db_config.php');

//query to delete customer using id
if (isset($_GET['id'])) {
    $customer_id =  $_GET['id'];
    $sql = "DELETE FROM customer WHERE id = " . $customer_id . "";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = 'customer deleted successfully.';
        header("Location: ./index.php");
    } else {
        $_SESSION['success'] = 'Error while deleting a customer.';
        header("Location: ./index.php");
    }
}




?>