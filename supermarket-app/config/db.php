<?php
$host = "localhost:3306"; 
$user = "root";
$pass = "";
$dbname = "supermarket_fix";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
