<?php
define("DB_HOST", "localhost");
define("DB_USER", "raghav3");
define("DB_PASS", "Raghu@123");
define("DB_DATABASE", "php_tutorial");

$conn = new mysqli(DB_HOST,DB_USER, DB_PASS, DB_DATABASE);

if($conn->connect_error)
{
    die("connection failed: ".$connect_error);
}
?>